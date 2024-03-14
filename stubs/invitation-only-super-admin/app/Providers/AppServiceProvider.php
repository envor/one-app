<?php

namespace App\Providers;

use App\Models\SuperAdmin;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Gate::before(function (SuperAdmin|User $user, string $ability) {
            if ($user instanceof SuperAdmin) {
                return true;
            }
        });

        Gate::after(function (SuperAdmin|User $user, string $ability, ?bool $result, mixed $arguments) {
            if ($user instanceof SuperAdmin) {
                return true;
            }
        });
    }
}

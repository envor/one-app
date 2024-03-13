<?php

namespace App\Providers;

use Envor\Datastore\Contracts\HasDatastoreContext;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\ServiceProvider;
use Laravel\Pennant\Feature;
use Laravel\Pennant\Middleware\EnsureFeaturesAreActive;

class FeaturesServiceProvider extends ServiceProvider
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

        Feature::resolveScopeUsing(fn ($driver) => $this->app->make(HasDatastoreContext::class)?->datastoreContext()?->datastore);

        EnsureFeaturesAreActive::whenInactive(
            function (Request $request, array $features) {
                abort(Response::HTTP_FORBIDDEN, 'Feature(s) not active: '.implode(', ', $features));
            }
        );

        Feature::discover();

        Feature::define('default', fn ($datastore) => true);
    }
}

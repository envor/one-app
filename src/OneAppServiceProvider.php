<?php

namespace Envor\OneApp;

use Envor\OneApp\Commands\InvitationOnlyCommand;
use Envor\OneApp\Commands\OneAppCommand;
use Envor\OneApp\Commands\PassportCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class OneAppServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('one-app')
            ->hasCommands([
                OneAppCommand::class,
                PassportCommand::class,
                InvitationOnlyCommand::class,
            ]);
    }
}

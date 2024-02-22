<?php

namespace Envor\OneApp;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Envor\OneApp\Commands\OneAppCommand;

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
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_one-app_table')
            ->hasCommand(OneAppCommand::class);
    }
}

<?php

namespace Marchampson\LaravelDbUtils;

use Marchampson\LaravelDbUtils\Commands\LaravelDbUtilsDumpCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelDbUtilsServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-db-utils')
            ->hasConfigFile()
            ->hasCommand(LaravelDbUtilsDumpCommand::class);
    }
}

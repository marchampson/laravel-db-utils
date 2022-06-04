<?php

namespace Marchampson\LaravelDbUtils;

use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;
use Marchampson\LaravelDbUtils\Commands\LaravelDbUtilsCommand;

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
            ->hasCommand(LaravelDbUtilsCommand::class);
    }
}

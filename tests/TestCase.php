<?php

namespace Marchampson\LaravelDbUtils\Tests;

use Illuminate\Database\Eloquent\Factories\Factory;
use Marchampson\LaravelDbUtils\LaravelDbUtilsServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

class TestCase extends Orchestra
{
    protected function setUp(): void
    {
        parent::setUp();

        Factory::guessFactoryNamesUsing(
            fn (string $modelName) => 'Marchampson\\LaravelDbUtils\\Database\\Factories\\'.class_basename($modelName).'Factory'
        );
    }

    protected function getPackageProviders($app)
    {
        return [
            LaravelDbUtilsServiceProvider::class,
        ];
    }

    public function getEnvironmentSetUp($app)
    {
        config()->set('database.default', 'testing');

        /*
        $migration = include __DIR__.'/../database/migrations/create_laravel-db-utils_table.php.stub';
        $migration->up();
        */
    }
}

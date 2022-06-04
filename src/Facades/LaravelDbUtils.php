<?php

namespace Marchampson\LaravelDbUtils\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Marchampson\LaravelDbUtils\LaravelDbUtils
 */
class LaravelDbUtils extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'laravel-db-utils';
    }
}

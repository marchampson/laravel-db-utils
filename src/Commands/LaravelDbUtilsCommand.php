<?php

namespace Marchampson\LaravelDbUtils\Commands;

use Illuminate\Console\Command;

class LaravelDbUtilsCommand extends Command
{
    public $signature = 'laravel-db-utils';

    public $description = 'My command';

    public function handle(): int
    {
        $this->comment('All done');

        return self::SUCCESS;
    }
}

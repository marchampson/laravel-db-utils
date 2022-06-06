<?php

namespace Marchampson\LaravelDbUtils\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class LaravelDbUtilsCreateCommand extends Command
{
    public $signature = 'dbu:create
                        {--name= : Name of the database to create}
                        {--debug : Display the underlying command}';

    public $description = 'Create mysql database';

    public function handle()
    {
        if ($this->option('debug')) {
            $this->info($this->create());

            return;
        }

        Process::fromShellCommandline($this->create())
            ->setTty(true)
            ->setTimeout(null)
            ->run();

        $this->info('Database ' . $this->option('name') . ' has been created successfully');
    }

    public function create()
    {
        return '\\mysqladmin -u root create ' . $this->option('name');
    }
}

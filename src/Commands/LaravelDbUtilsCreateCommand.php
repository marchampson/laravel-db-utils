<?php

namespace Marchampson\LaravelDbUtils\Commands;

use Illuminate\Console\Command;
use RuntimeException;
use Symfony\Component\Process\Process;

class LaravelDbUtilsCreateCommand extends Command
{
    public $signature = 'dbu:dump
                        {--debug : Display the underlying command}';

    public $description = 'Create mysqldump file using Artisan';

    public function handle()
    {
        if ($this->option('debug')) {
            $this->info($this->dump());

            return;
        }

        Process::fromShellCommandline($this->dump())
            ->setTty(true)
            ->setTimeout(null)
            ->run();
    }

    public function getCreate()
    {
        return '\\mysqladmin -u root create ' . $this->option('create');
    }

    public function getDump()
    {
        // Setup
        $output_dir = $this->createDirectoryIfNotExists();
        $database = config('database.connections.mysql.database');
        $filename = $this->setOutputFilename($database);

        return '\\mysqldump -u root ' . $database . ' > ' . $output_dir . '/' . $filename . '.sql';
    }

    public function setOutputFilename($database): string
    {
        $filename = strtolower($database);

        $timestamp = config('db-utils.dump.timestamp');

        if ($timestamp) {
            $filename .= '-' . date('d-m-Y-H-i');
        }

        return $filename;
    }

    /**
     * @return string
     */
    public function createDirectoryIfNotExists(): string
    {
        $output_dir = config('db-utils.dump.output_dir');
        if (! file_exists($output_dir) && ! mkdir($output_dir, 0777, true) && ! is_dir($output_dir)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $output_dir));
        }

        return $output_dir;
    }
}

<?php

namespace Marchampson\LaravelDbUtils\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Process\Process;

class LaravelDbUtilsDumpCommand extends Command
{
    protected string $database;
    protected string $output_dir;
    protected string $filename;

    public $signature = 'dbu:dump
                        {--debug : Display the underlying command}';

    public $description = 'Create mysqldump file using Artisan';

    public function handle()
    {
        $this->dumpSetup();

        if ($this->option('debug')) {
            $this->database = 'test';
            $this->filename = 'test.sql';
            $this->info($this->dump());

            return;
        }


        if (!$this->createOutputDirectoryIfNotExists()) {
            return;
        }

        Process::fromShellCommandline($this->dump())
            ->setTty(true)
            ->setTimeout(null)
            ->run();

        $this->info($this->database . ' has been backed up successfully');

    }

    public function dumpSetup()
    {
        $this->output_dir = config('db-utils.dump.output_dir');
        $this->database = config('database.connections.mysql.database');
        $this->filename = $this->setOutputFilename();
    }

    public function dump()
    {
        return '\\mysqldump -u root ' . $this->database . ' > ' . $this->output_dir . '/' . $this->filename;
    }

    public function setOutputFilename(): string
    {
        $filename = strtolower($this->database);

        $timestamp = config('db-utils.dump.timestamp');

        if ($timestamp) {
            $filename .= '-' . date('d-m-Y-H-i');
        }

        $filename .= '.sql';

        return $filename;
    }

    /**
     * @return bool
     */
    public function createOutputDirectoryIfNotExists(): bool
    {
        return !(!file_exists($this->output_dir)
            && !mkdir($this->output_dir, 0777, true)
            && !is_dir($this->output_dir));
    }
}

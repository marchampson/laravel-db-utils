<?php

namespace Marchampson\LaravelDbUtils\Commands;

use Illuminate\Console\Command;
use RuntimeException;
use Symfony\Component\Process\Process;

class LaravelDbUtilsCommand extends Command
{
    protected $util;
    protected $command_options = ['v','create','dump'];

    public $signature = 'dbu
                        {--v : Current version of MySQL}
                        {--create= : Create database}
                        {--dump : Create mysqldump file}';

    public $description = 'A package to make common database utilities available as artisan commands';

    public function handle()
    {
        foreach ($this->command_options as $command_option) {
            if ($this->option($command_option)) {
                $this->util = $this->option($command_option)
                    ? $command_option
                    : null;

                break;
            }
        }

        if ($this->util) {
            Process::fromShellCommandline($this->{'get'.ucfirst($this->util)}())
                ->setTty(true)
                ->setTimeout(null)
                ->run();

            if ($this->util !== 'v') {
                $this->info('The ' . $this->util . ' command was successful!');
            }
        }
    }

    public function getV()
    {
        return '\\mysql -V';
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
            $filename .= '-'.date('d-m-Y-H-i');
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

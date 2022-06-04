<?php

namespace Marchampson\LaravelDbUtils\Commands;

use Illuminate\Console\Command;
use RuntimeException;
use Symfony\Component\Process\Process;

class LaravelDbUtilsCommand extends Command
{
    protected $util;

    protected $command_options = ['dbv','dump'];

    public $signature = 'db
                        {--ver : Current version of MySQL}
                        {--dump : Creat mysqldump file}';

    public $description = 'A package to make common database utilities available as artisan commands';

    public function handle()
    {
        foreach($this->command_options as $command_option) {
            if($this->option($command_option)) {
                $this->util = $this->option($command_option)
                    ? $command_option
                    : null;

                break;
            }
        }

        if($this->util) {
            Process::fromShellCommandline($this->{'get'.ucfirst($this->util)}())
                ->setTty(true)
                ->setTimeout(null)
                ->run();

            if($this->util !== 'dbv') {
                $this->info('The ' . $this->util . ' command was successful!');
            }
        }
    }

    public function getDbv()
    {
        return '\\mysql -V';
    }

    public function getDump()
    {
        // Setup
        $output_dir = config('mysql-db-utils.dump.output_dir');
        $timestamp = config('mysql-db-utils.dump.timestamp');
        $database = config('database.connections.mysql.database');

        $filename = strtolower($database);

        if($timestamp) {
            $filename .= '-'.date('d-m-Y-H-i');
        }

        $this->createDirectoryIfNotExists($output_dir);
        return '\\mysqldump -u root ' . $database . ' > ' . $output_dir . '/' . $filename . '.sql';
    }

    /**
     * @param mixed $output_dir
     * @return void
     */
    public function createDirectoryIfNotExists(mixed $output_dir): void
    {
        if (!file_exists($output_dir) && !mkdir($output_dir, 0777, true) && !is_dir($output_dir)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $output_dir));
        }
    }
}

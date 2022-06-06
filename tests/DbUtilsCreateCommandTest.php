<?php

namespace Marchampson\LaravelDbUtils\Tests;

class DbUtilsDumpCommandTest extends TestCase
{
    /** @test */
    public function the_dump_command_is_correct()
    {
        $this
            ->artisan('dbu:dump', [
                '--debug' => true,
            ])
            ->expectsOutput('\mysqldump -u root test > ~/Downloads/test.sql');
    }
}

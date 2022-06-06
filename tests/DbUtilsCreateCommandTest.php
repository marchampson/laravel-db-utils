<?php

namespace Marchampson\LaravelDbUtils\Tests;

class DbUtilsCreateCommandTest extends TestCase
{
    /** @test */
    public function the_create_command_is_correct()
    {
        $this
            ->artisan('dbu:create', [
                '--name' => 'test',
                '--debug' => true,
            ])
            ->expectsOutput('\mysqladmin -u root create test');
    }
}

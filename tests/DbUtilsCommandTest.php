<?php

it('can return the mysql version', function() {
    $this
        ->artisan('tail', [
            '--debug' => true,
        ])
        ->expectsOutput('\\tail -f -n 0 "`\\ls -t | \\head -1`"');
});

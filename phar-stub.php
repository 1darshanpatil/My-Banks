#!/usr/bin/env php 
<?php
if (php_sapi_name() === 'cli-server') {
    return false; // Serve files directly if running under PHP built-in server
}

Phar::mapPhar('app.phar');

/*
Create a temporary directory to extract the contents of the Phar
*/
$tmpDir = sys_get_temp_dir() . '/app_phar_' . uniqid();
if (!file_exists($tmpDir)) {
    mkdir($tmpDir, 0777, true);
}

/*
Extract all contents from the Phar archive to the temporary directory
*/
$phar = new Phar('app.phar');
$phar->extractTo($tmpDir);

/*
Start the PHP built-in server
*/
echo "Starting web server at http://localhost:8000\n";
passthru("php -S localhost:8000 -t $tmpDir");

/*
Clean up the temporary directory when the script stops
*/
register_shutdown_function(function () use ($tmpDir) {
    if (file_exists($tmpDir)) {
        passthru("rm -rf " . escapeshellarg($tmpDir));
    }
});

__HALT_COMPILER();
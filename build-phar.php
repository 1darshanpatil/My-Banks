<?php
$phar = new Phar('app.phar', FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, 'app.phar');
$phar->buildFromDirectory(__DIR__); // Add all files from current directory
$phar->setStub(file_get_contents('phar-stub.php')); // Set the stub
echo "Phar archive created successfully.\n";
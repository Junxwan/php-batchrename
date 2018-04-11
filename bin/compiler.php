<?php

require __DIR__ . '/../vendor/autoload.php';

use Junxwan\Compiler;

error_reporting(-1);
ini_set('display_errors', 1);

try {
    $compiler = new Compiler('rename.phar');
    $compiler->compiler();
} catch (\Exception $e) {
    echo 'Failed to compile phar: [' . get_class($e) . '] ' . $e->getMessage() . ' at ' . $e->getFile() . ':' . $e->getLine() . PHP_EOL;
    exit(1);
}

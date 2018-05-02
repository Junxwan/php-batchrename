<?php

use Junxwan\Console\RenameCommand;
use Symfony\Component\Console\Application as Console;
use Symfony\Component\Console\Tester\ApplicationTester;

class ConsoleTest extends \PHPUnit\Framework\TestCase
{
    public function testNoRenameCommand()
    {
        $console = new Console();
        $console->setAutoExit(false);
        $console->setCatchExceptions(false);
        $console->add($rename = new RenameCommand());


        $tester = new ApplicationTester($console);
        $tester->run([
            'command' => 'rename',
            'name'    => 'test',
            'path'    => __DIR__ . '/data',
        ]);

        $this->assertEquals("
Batch Rename List
=================

 test1.txt
 test2.txt
 test3.txt

 [WARNING] no rename file                                                       

", $tester->getDisplay());
    }
}

<?php

use Junxwan\Console\RenameCommand;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application as Console;
use Symfony\Component\Console\Tester\ApplicationTester;

class ConsoleTest extends \PHPUnit\Framework\TestCase
{
    public function testRunCommand()
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

        $this->assertEquals(0, $tester->getStatusCode());
    }

    public function testNoRenameCommand()
    {
        $console = new CommandTester(new RenameCommand());
        $console->setInputs(['no']);

        $console->execute([
            'name' => 'test',
            'path' => __DIR__ . '/data',
        ]);

        $this->assertEquals("
Batch Rename List
=================

 test1.txt
 test2.txt
 test3.txt

 Are you rename file (yes/no) [no]:
 > 
 [WARNING] no rename file                                                       

", $console->getDisplay());
    }

    public function testRenameCommand()
    {
        $console = new CommandTester(new RenameCommand());
        $console->setInputs(['yes']);

        $console->execute([
            'name' => 'test',
            'path' => __DIR__ . '/data',
        ]);

        $this->assertEquals('
Batch Rename List
=================

 test1.txt
 test2.txt
 test3.txt

 Are you rename file (yes/no) [no]:
 > 
 [OK] success                                                                   

', $console->getDisplay());
    }
}

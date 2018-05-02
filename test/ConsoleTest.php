<?php

use Junxwan\Console\RenameCommand;
use Symfony\Component\Console\Tester\CommandTester;
use Symfony\Component\Console\Application as Console;
use Symfony\Component\Console\Tester\ApplicationTester;

class ConsoleTest extends \PHPUnit\Framework\TestCase
{
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

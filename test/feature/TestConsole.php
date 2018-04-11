<?php

use Junxwan\Console\Application;
use Junxwan\Console\RenameCommand;
use Symfony\Component\Console\Tester\ApplicationTester;

class TestConsole extends \PHPUnit\Framework\TestCase
{
    public function testRenameCommand()
    {
        $console = new Application();
        $console->setAutoExit(false);
        $console->setCatchExceptions(false);
        $console->add($rename = new RenameCommand());

        $tester = new ApplicationTester($console);
        $tester->run([
            'command' => 'rename',
            'name'    => 'test',
            'path'    => __DIR__ . '/../data',
        ]);

        $this->assertEquals( "success\n", $tester->getDisplay());
    }
}
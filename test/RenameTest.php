<?php

use Junxwan\Rename;

class RenameTest extends \PHPUnit\Framework\TestCase
{
    public function testFileList()
    {
        $rename = new Rename(__DIR__ . '/data');

        $this->assertCount(3, $rename->lists());
    }

    public function testRenameFileToCurrentTime()
    {
        $_ENV['APP_ENV'] = 'production';

        $rename = new Rename(__DIR__ . '/data');

        $rename->to($name = time());

        $this->assertEquals([
            $name . '-1.txt',
            $name . '-2.txt',
            $name . '-3.txt',
        ], $rename->lists());
    }
}

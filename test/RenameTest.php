<?php

use Junxwan\Rename;

class RenameTest extends \PHPUnit\Framework\TestCase
{
    public function testFileList()
    {
        $rename = $this->getTarget();

        $this->assertCount(3, $rename->lists());
    }

    public function testRenameFileToCurrentTime()
    {
        $_ENV['APP_ENV'] = 'production';

        $rename = $this->getTarget();

        $rename->to($name = time());

        $this->assertEquals([
            $name . '-01.txt',
            $name . '-02.txt',
            $name . '-03.txt',
        ], $rename->lists());
    }

    /**
     * @return Rename
     */
    private function getTarget()
    {
        return new Rename(__DIR__ . '/data');
    }
}

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
            $name . '-1.txt',
            $name . '-2.txt',
            $name . '-3.txt',
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

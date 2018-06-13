<?php

use Junxwan\Rename;

class RenameTest extends \PHPUnit\Framework\TestCase
{
    protected function tearDown()
    {
        $rename = $this->getTarget();

        $rename->to('test', 1, 2);
    }

    public function testFileList()
    {
        $rename = $this->getTarget();

        $this->assertCount(3, $rename->lists());
    }

    public function testRenameFileToCurrentTime()
    {
        $rename = $this->getTarget();

        $rename->to($name = time());

        $this->assertEquals([
            $name . '-01.txt',
            $name . '-02.txt',
            $name . '-03.txt',
        ], $rename->lists());
    }

    public function testFormatZeroName()
    {
        $rename = $this->getTarget();

        $rename->to($name = time(), 1, 3);

        $this->assertEquals([
            $name . '-001.txt',
            $name . '-002.txt',
            $name . '-003.txt',
        ], $rename->lists());
    }

    public function testStartNumberName()
    {
        $rename = $this->getTarget();

        $rename->to($name = time(), 10);

        $this->assertEquals([
            $name . '-10.txt',
            $name . '-11.txt',
            $name . '-12.txt',
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

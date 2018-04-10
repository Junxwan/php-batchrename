<?php

use Junxwan\Rename;

class TestRename extends \PHPUnit\Framework\TestCase
{
    public function testFileList()
    {
        $rename = new Rename(__DIR__ . '/../data');

        $this->assertCount(3, $rename->lists());
    }

    public function testRenameFileToCurrentTime()
    {
        $rename = new Rename(__DIR__ . '/../data');

        $rename->to($name = time());

        $fileName = $rename->lists();

        $this->assertContains($name . '-1.txt', $fileName);
        $this->assertContains($name . '-2.txt', $fileName);
        $this->assertContains($name . '-3.txt', $fileName);
    }
}

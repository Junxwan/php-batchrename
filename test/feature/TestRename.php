<?php

use Junxwan\Rename;

class TestRename extends \PHPUnit\Framework\TestCase
{
    public function testFileList()
    {
        $rename = new Rename(__DIR__ . '/../data');

        $this->assertEquals(3, $rename->file()->count());
    }
}

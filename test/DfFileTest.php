<?php
/**
 * Daitel Framework
 * Test Class for file work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 *
 */

class DfFileTest extends PHPUnit_Framework_TestCase{

    private $file;

    public function testWrite()
    {
        $this->file = new DfFile('');
        $this->assertEquals(false, $this->file ->write('true'));

        $this->file = new DfFile('test.txt');
        $this->assertEquals(true, $this->file ->write('true'));

        $this->file = new DfFile('test.txt');
        $this->assertEquals(true, $this->file ->write('true', true));
    }

    public function testRead(){
        $this->assertEquals("true\n", $this->file->read());

        $this->file = new DfFile('');
        $this->assertEquals(false, $this->file->read());
    }
}
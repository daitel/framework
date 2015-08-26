<?php
/**
 * Daitel Framework
 * Test Class for file work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 *
 */
class DfFileTest extends PHPUnit_Framework_TestCase
{
    public function testWrite()
    {
        $file = new DfFile('');
        $this->assertEquals(false, $file->write('true'));

        $file = new DfFile(DfTests::$testDir . 'DfFileTest.txt');
        $this->assertEquals(true, $file->write('true'));

        $file = new DfFile(DfTests::$testDir . 'DfFileTest.txt');
        $this->assertEquals(true, $file->write('true'));

        $file = new DfFile(DfTests::$testDir . 'DfFileTest.txt');
        $this->assertEquals(true, $file->write('true', true));
    }

    public function testRead()
    {
        $file = new DfFile(DfTests::$testDir . 'DfFileTest.txt');
        $this->assertEquals("true\n", $file->read());

        $file = new DfFile('');
        $this->assertEquals(false, $file->read());
    }
}
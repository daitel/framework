<?php
/**
 * @link https://github.com/daitel/framework
 */
use df\utils\File;

/**
 * Daitel Framework
 * Test Class for file work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 *
 */
class FileTest extends PHPUnit_Framework_TestCase
{
    public function testWrite()
    {
        $file = new File('');
        $this->assertEquals(false, $file->write('true'));

        $file = new File(DfTests::$testDir . 'FileTest.txt');
        $this->assertEquals(true, $file->write('true'));

        $file = new File(DfTests::$testDir . 'FileTest.txt');
        $this->assertEquals(true, $file->write('true'));

        $file = new File(DfTests::$testDir . 'FileTest.txt');
        $this->assertEquals(true, $file->write('true', true));
    }

    public function testRead()
    {
        $file = new File(DfTests::$testDir . 'FileTest.txt');
        $this->assertEquals("true\n", $file->read());

        $file = new File('');
        $this->assertEquals(false, $file->read());
    }
}
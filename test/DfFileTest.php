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

    public function testWrite()
    {
        $this->assertEquals(true, DfFile::write('log.txt', 'test'));
        $this->assertEquals(false, DfFile::write('', 'test'));
        $this->assertEquals(false, DfFile::write('log.txt', ''));
    }
}
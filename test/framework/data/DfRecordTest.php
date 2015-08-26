<?php
/**
 * Daitel Framework
 * Test Class for test work with record
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class DfRecordTest extends PHPUnit_Framework_TestCase
{
    public function testRecord()
    {
        $record = new DfRecord(['c' => 'd']);

        $record->a = 'b';
        $this->assertEquals('b', $record->a);
    }
}
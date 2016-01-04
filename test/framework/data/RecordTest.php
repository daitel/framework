<?php
/**
 * @link https://github.com/daitel/framework
 */

use daitel\framework\data\Record;

/**
 * Daitel Framework
 * Test Class for test work with record
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class RecordTest extends PHPUnit_Framework_TestCase
{
    public function testRecord()
    {
        $record = new Record(['c' => 'd']);

        $record->a = 'b';
        $this->assertEquals('b', $record->a);
    }
}
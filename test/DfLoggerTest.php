<?php
/**
 * Daitel Framework
 * Test Class for file work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 *
 */

class DfLoggerTest extends PHPUnit_Framework_TestCase
{

    public function testSave()
    {
        $logger = new DfLogger();
        $logger->log('log', 'log', 'log', 'log');
        $logger->save('log.txt');

        $this->assertEquals(true, file_exists('log.txt'));
    }
}
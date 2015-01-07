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

    public function testWriteErrors()
    {
        $logger = new DfLogger('log.txt');
        $errors['danger']['test']['00-00-00 00:00:00']['test'] = 'test';
        $logger->writeErrors($errors);

        $file = new DfFile('log.txt');
        $this->assertEquals("[00-00-00 00:00:00][danger][test] | test [test]\n", $file->read());
    }
}
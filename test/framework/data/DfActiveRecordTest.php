<?php
/**
 * Daitel Framework
 * Test Class for test work with db active record
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class DfActiveRecordTest extends PHPUnit_Framework_TestCase
{
    public function testName(){
        $this->assertEquals('users', Users::getName());
    }
}
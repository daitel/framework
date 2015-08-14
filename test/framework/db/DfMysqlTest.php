<?php
/**
 * Daitel Framework
 * Test Class for mysql work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class DfMysqlTest extends PHPUnit_Framework_TestCase
{
    public function testConstruct()
    {
        $this->assertEquals(false, is_object(DfApp::app()->mysql));
    }
}
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
    /**
     * @coversNothing
     */
    public function testConstruct()
    {
        $this->assertEquals(true, is_object(DfApp::app()->mysql));
    }
}
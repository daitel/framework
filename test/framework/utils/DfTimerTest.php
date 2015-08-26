<?php
/**
 * Daitel Framework
 * Test Class for timer work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class DfTimerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @depends DfAppTest::testSetupEx
     */
    public function testStart()
    {
        $this->assertEquals(true, DfApp::app()->timer->start('1'));
        $this->assertEquals(false, DfApp::app()->timer->start('1'));
    }

    /**
     * @depends DfAppTest::testSetupEx
     */
    public function testStop()
    {
        $this->assertEquals(true, is_numeric(DfApp::app()->timer->stop()));
        $this->assertEquals(true, is_numeric(DfApp::app()->timer->stop('1')));
    }
}
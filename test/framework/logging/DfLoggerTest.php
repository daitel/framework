<?php
/**
 * Daitel Framework
 * Test Class for file work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @requires DfAppTest
 */
class DfLoggerTest extends PHPUnit_Framework_TestCase
{
    /**
     * @depends DfAppTest::testSetupEx
     */
    public function testLog()
    {
        $this->assertTrue(is_object(DfApp::app()->logger));
        DfApp::app()->logger->log('log', 'log', 'log', 'log');

        $logData = DfApp::app()->logger->getLogData();
        $this->assertEquals(true, (!empty($logData)));

        $logData = DfApp::app()->logger->getLogDataByComponent('log');
        $this->assertEquals(true, (!empty($logData)));

        $logData = DfApp::app()->logger->getLogDataByLevel('log');
        $this->assertEquals(true, (!empty($logData)));

        $logData = DfApp::app()->logger->getLogDataByType('log');
        $this->assertEquals(true, (!empty($logData)));
    }

    /**
     * @depends testLog
     */
    public function testSave()
    {
        DfApp::app()->logger->path = DfTests::$testDir . 'log.txt';
        DfApp::app()->logger->save();

        $this->assertEquals(true, file_exists(DfTests::$testDir . 'log.txt'));
    }
}
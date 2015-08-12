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
    /**
     * @covers DfLogger::log
     * @covers DfLogger::getLogData
     * @covers DfLogger::getLogDataByComponent
     * @covers DfLogger::getLogDataByLevel
     * @covers DfLogger::getLogDataByType
     */
    public function testLog()
    {
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
     * @covers DfLogger::save
     */
    public function testSave()
    {
        DfApp::app()->logger->save(DfTests::$testDir . 'log.txt');
        $this->assertEquals(true, file_exists(DfTests::$testDir . 'log.txt'));
    }
}
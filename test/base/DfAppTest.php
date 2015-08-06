<?php
/**
 * Daitel Framework
 * Test Class for DfApp work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class DfAppTest extends PHPUnit_Framework_TestCase
{
    /**
     * Config array
     * @var array
     */
    private $config = [];

    /**
     * @covers DfApp::start
     */
    public function testStart()
    {
        if (empty($config)) {
            $this->configWrite();
        }

        DfApp::start($this->config);
        $this->assertEquals(DfApp::getPath(), $this->config['app_path']);
        $this->assertEquals(DfApp::getPath(true), $this->config['app_path'] . "/");
    }

    /**
     * Example of config file writer
     */
    private function configWrite()
    {
        $this->config = [
            'app_path' => 'localhost'
        ];
    }
}
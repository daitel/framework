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

    public function testSetupEx()
    {
        try {
            DfApp::start($this->config, 'test/data');
        } catch (DfSetupException $ex) {
            $this->assertEquals("DfSetupException", get_class($ex));
        } finally {
            $this->start();
        }
    }

    private function start()
    {
        if (empty($config)) {
            $this->configWrite();
        }

        DfApp::start($this->config, 'test/data');
        $this->assertEquals(DfApp::getPath(), $this->config['app_path']);
        $this->assertEquals(DfApp::getPath(true), $this->config['app_path'] . "/");
    }

    private function configWrite()
    {
        $this->config = [
            'app_path' => 'localhost'
        ];
    }
}
<?php
/**
 * @link https://github.com/daitel/framework
 */

use df\base\SetupException;

/**
 * Test Class for Df work
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
        } catch (SetupException $ex) {
            $this->assertEquals("SetupException", get_class($ex));
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
        $this->assertEquals(DfApp::getPath(), $this->config['application_path']);
        $this->assertEquals(DfApp::getPath(true), $this->config['application_path'] . "/");
    }

    private function configWrite()
    {
        $this->config = [
            'application_path' => 'localhost',
            'components' => [
                'db' => [
                    'link' => 'mysql:host=localhost;dbname=test;charset=utf8',
                    'user' => 'root',
                    'password' => ''
                ]
            ],
            'errors' => [
                'debug' => true,
            ],
        ];
    }
}
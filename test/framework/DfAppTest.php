<?php
/**
 * @link https://github.com/daitel/framework
 */

use daitel\framework\base\SetupException;
use daitel\framework\utils\ClassHelper;

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
            DfApp::start($this->config);
        } catch (SetupException $ex) {
            $this->assertEquals("SetupException", ClassHelper::getNameFromClass($ex));
        } finally {
            $this->start();
        }
    }

    private function start()
    {
        if (empty($config)) {
            $this->configWrite();
        }

        DfApp::start($this->config);
        $this->assertEquals(DfApp::getUrl(), $this->config['applicationUrl']);
        $this->assertEquals(DfApp::getUrl(true), $this->config['applicationUrl'] . "/");
    }

    private function configWrite()
    {
        $this->config = [
            'applicationUrl' => 'localhost',
            'applicationPath' => ['test/data', 1],
            'components' => [
                'db' => DfTests::$config['db']
            ],
            'errors' => [
                'debug' => true,
            ],
        ];
    }
}
<?php
/**
 * Daitel Framework
 * Test Class for MVC Router work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class DfMVCTest extends PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        $mvc = $this->testInit();

        $this->assertFalse($mvc->execute());
        define('DF_APP_PATH', realpath(DfTests::$dataDir));
        $mvc->execute();
        $mvc = null;

        $mvc = new DfMVC("http://localhost/main/main");
        $mvc->action = 'main';
        $this->assertFalse($mvc->execute());
        $mvc = null;

        $mvc = new DfMVC("http://localhost/main1/index");
        $mvc->controller = 'main1';
        $mvc->action = 'index';
        $this->assertFalse($mvc->execute());
        $mvc = null;

    }

    public function testInit()
    {
        $mvc = new DfMVC();
        $this->assertEquals('main', $mvc->controller);
        $this->assertEquals('index', $mvc->action);
        $this->assertTrue(empty($mvc->id));
        $this->assertTrue(empty($mvc->variables['a']));
        $this->assertTrue(empty($mvc->variables['b']));
        $this->assertTrue(empty($mvc->fragment));

        $mvc = null;

        $mvc = new DfMVC('http://localhost/main/index/id?a=1&b=c#123');
        $this->assertEquals('main', $mvc->controller);
        $this->assertEquals('index', $mvc->action);
        $this->assertEquals('id', $mvc->id);
        $this->assertEquals('1', $mvc->variables['a']);
        $this->assertEquals('c', $mvc->variables['b']);
        $this->assertEquals('123', $mvc->fragment);
        return $mvc;
    }
}
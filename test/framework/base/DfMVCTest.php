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
    /**
     * @depends DfAppTest::testSetupEx
     */
    public function testInit()
    {
        $mvc = new DfMVC();
        $mvc->process();
        $this->assertEquals('main', $mvc->controller);
        $this->assertEquals('index', $mvc->action);
        $this->assertTrue(empty($mvc->id));
        $this->assertTrue(empty($mvc->variables['a']));
        $this->assertTrue(empty($mvc->variables['b']));
        $this->assertTrue(empty($mvc->fragment));

        $mvc = null;

        $mvc = new DfMVC('http://localhost/main/index/id?a=1&b=c#123', true);
        $this->assertEquals('main', $mvc->controller);
        $this->assertEquals('index', $mvc->action);
        $this->assertEquals('id', $mvc->id);
        $this->assertEquals('1', $mvc->variables['a']);
        $this->assertEquals('c', $mvc->variables['b']);
        $this->assertEquals('123', $mvc->fragment);
    }

    /**
     * @depends testInit
     * @expectedException DfViewFileException
     */
    public function viewEx()
    {
        $mvc = new DfMVC("http://localhost/main/test/main123", true);
        $mvc->call();
    }

    /**
     * @depends testInit
     * @expectedException DfNotFoundException
     */
    public function testIncorrectPaths()
    {
        $mvc = new DfMVC("http://localhost/main/main", true);
        $this->assertEquals('main', $mvc->controller);
        $this->assertEquals('main', $mvc->action);
        $mvc->call();

        $mvc = new DfMVC("http://localhost/main1/index", true);
        $this->assertEquals('main1', $mvc->controller);
        $this->assertEquals('index', $mvc->action);
        $mvc->call();

        $mvc = new DfMVC("http://localhost/test/main1", true);
        $this->assertEquals('test', $mvc->controller);
        $this->assertEquals('main1', $mvc->action);
        $mvc->call();
    }
}
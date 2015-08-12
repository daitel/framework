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
     * @covers DfMVC
     */
    public function testInit()
    {
        $mvc = new DfMVC();
        $mvc->path = "controller/action/id?a=1&b=c";
        $mvc->init();
        $this->assertEquals($mvc->controller, 'controller');
        $this->assertEquals($mvc->action, 'action');
        $this->assertEquals($mvc->id, 'id');
        $this->assertEquals($mvc->variables['a'], '1');
        $this->assertEquals($mvc->variables['b'], 'c');
    }
}
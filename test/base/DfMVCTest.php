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
        $mvc = new DfMVC('http://localhost/controller/action/id?a=1&b=c#123');
        $this->assertEquals('controller', $mvc->controller);
        $this->assertEquals('action', $mvc->elements[1]);
        $this->assertEquals('id', $mvc->elements[2]);
        $this->assertEquals('1', $mvc->variables['a']);
        $this->assertEquals('c', $mvc->variables['b']);
        $this->assertEquals('123', $mvc->fragment);
    }
}
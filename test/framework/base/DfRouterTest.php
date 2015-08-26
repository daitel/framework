<?php
/**
 * Daitel Framework
 * Test Class for router work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class DfRouterTest extends PHPUnit_Framework_TestCase
{
    public function testInit()
    {
        $router = new DfRouter('http://localhost/controller/action/id?a=1&b=c');
        $this->assertEquals('controller', $router->elements[0]);
        $this->assertEquals('action', $router->elements[1]);
        $this->assertEquals('id', $router->elements[2]);
        $this->assertEquals('1', $router->variables['a']);
        $this->assertEquals('c', $router->variables['b']);
    }
}
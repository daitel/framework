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
    /**
     * @covers DfRouter
     */
    public function testInit()
    {
        $router = new DfRouter();
        $router->path = 'controller/action/id?a=1&b=c';
        $router->init();
        $this->assertEquals($router->elements[0], 'controller');
        $this->assertEquals($router->elements[1], 'action');
        $this->assertEquals($router->elements[2], 'id');
        $this->assertEquals($router->variables['a'], '1');
        $this->assertEquals($router->variables['b'], 'c');
    }
}
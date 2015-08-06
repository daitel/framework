<?php
/**
 * Daitel Framework
 * Test Class for router work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 *
 */
class DfRouterTest extends PHPUnit_Framework_TestCase
{
	public function testInit()
	{
		DfRouter::$path = 'controller/action/id?a=1&b=c';
		DfRouter::init();
		$this->assertEquals(DfRouter::$elements[0], 'controller');
		$this->assertEquals(DfRouter::$elements[1], 'action');
		$this->assertEquals(DfRouter::$elements[2], 'id');
		$this->assertEquals(DfRouter::$variables['a'], '1');
		$this->assertEquals(DfRouter::$variables['b'], 'c');
	}
}
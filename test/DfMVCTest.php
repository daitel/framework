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
	public function testInit()
	{
		DfMVC::$path = "controller/action/id?a=1&b=c";
		DfMVC::init();
		$this->assertEquals(DfMVC::$controller, 'controller');
		$this->assertEquals(DfMVC::$action, 'action');
		$this->assertEquals(DfMVC::$id, 'id');
		$this->assertEquals(DfMVC::$variables['a'], '1');
		$this->assertEquals(DfMVC::$variables['b'], 'c');
	}
}
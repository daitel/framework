<?php
/**
 * DfMVC is routing class for MVC pattern
 *
 * DfMVC class provide routing function
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.base
 * @since 0.2.1
 */
class DfMVC extends DfRouter
{
	/**
	 * @var string
	 */
	public static $controller;
	/**
	 * @var string
	 */
	public static $action;
	/**
	 * @var string|int
	 */
	public static $id;

	/**
	 * Initialization
	 */
	public static function init()
	{
		parent::init();
		static::set();
	}

	/**
	 * Set Variables
	 */
	private static function set()
	{
		if (isset(static::$elements[0])) {
			static::$controller = static::$elements[0];
			if (isset(static::$elements[1])) {
				static::$action = static::$elements[1];
				if (isset(static::$elements[2])) {
					static::$id = static::$elements[2];
				}
			}
		}
	}
} 
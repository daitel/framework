<?php
/**
 * DfRouter is base routing class
 *
 * DfRouter class provide routing function
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.base
 * @since 2.0.1
 */
class DfRouter
{
	/**
	 * Elements
	 * @var array
	 */
	public static $elements = [];
	/**
	 * Get Variables
	 * @var array
	 */
	public static $variables = [];
	/**
	 * Path
	 * @var string
	 */
	public static $path = "";

	/**
	 * Init
	 */
	public static function init()
	{
		if (static::$path == '') {
			static::setPath((isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : ''));
		}

		static::setElements();
	}

	/**
	 * Set Url path
	 * @param $path
	 */
	private static function setPath($path)
	{
		static::$path = ltrim($path, '/');
	}

	/**
	 * Set Elements and variables
	 */
	private static function setElements()
	{
		$general_elements = explode("?", static::$path);
		if (isset($general_elements[0])) {
			static::$elements = explode("/", $general_elements[0]);
		}

		if (isset($general_elements[1])) {
			$variables = explode("&", $general_elements[1]);

			foreach ($variables as $var) {
				list($name, $value) = explode("=", $var);
				static::$variables[$name] = $value;
			}
		}
	}
} 
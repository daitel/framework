<?php
/**
 * DfApp is base class
 *
 * DfApp class provide main functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.base
 * @since 0.2.1
 */
class DfApp extends DfMVC
{
	/**
	 * Application path
	 * Example: localhost
	 * @var string
	 */
	private static $app_path;
	/**
	 * Application
	 * @var DfApp
	 */
	private static $app;
	/**
	 * Logger
	 * @var DfLogger
	 */
	private $Logger;
	/**
	 * Timer
	 * @var DfTimer
	 */
	private $Timer;

	/**
	 * Start App
	 * @param array $config
	 */
	public static function start($config = [])
	{
		static::configRead($config);
		parent::init();
		DfApp::app()->timer()->start();
	}

	/**
	 * Config Reading
	 * @param $config
	 */
	private static function configRead($config)
	{
		if (isset($config['app_path'])) {
			static::$app_path = trim($config['app_path'], "/");
		}
	}

	/**
	 * Returning app path
	 * @param bool $slash
	 * @return string
	 */
	public static function getPath($slash = false)
	{
		return ($slash == true ? static::$app_path . "/" : static::$app_path);
	}

	/**
	 * Application copy for non-static call
	 * @return DfApp
	 */
	public static function app()
	{
		if (static::$app === null) {
			static::$app = new DfApp;
		}

		return static::$app;
	}

	/**
	 * Return DfLogger
	 * @return DfLogger
	 */
	public function log()
	{
		return $this->getObject('DfLogger');
	}

	/**
	 * Return DfTimer
	 * @return DfTimer
	 */
	public function timer()
	{
		return $this->getObject('DfTimer');
	}

	/**
	 * Return copy of class
	 * @param string $name
	 * @return object
	 */
	private function getObject($name)
	{
		$copyName = str_replace("Df", "", $name);

		if ($this->$copyName === null) {
			$this->$copyName = new $name();
		}

		return $this->$copyName;
	}
}
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
class DfApp
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
    private $logger;
    /**
     * Timer
     * @var DfTimer
     */
    private $timer;
    /**
     * Router
     * @var DfMVC
     */
    private $router;
    /**
     * Mysql
     * @var DfMysql
     */
    private $mysql;

    /**
     * Initialization process
     */
    public static function init()
    {
        DfApp::app()->timer = new DfTimer();
        DfApp::app()->timer->start();

        DfApp::app()->router = new DfMVC();
        DfApp::app()->router->init();
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
     * Start App
     * @param array $config
     */
    public static function start($config = [])
    {
        static::configRead($config);
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

        if (isset($config['components'])) {
            if (isset($config['components']['mysql'])) {
                DfApp::app()->mysql = new DfMysql($config['components']['mysql']);
            }
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
     * Magic Get
     * @param $name
     * @return bool
     */
    public function __get($name)
    {
        return $this->getObject($name);
    }

    /**
     * Get Object
     * @param $name
     * @return bool
     */
    private function getObject($name)
    {
        $className = "Df" . ucwords($name);

        if ($this->app()->$name === null) {
            if (class_exists($className)) {
                $this->app()->$name = new $className;
            } else {
                return false;
            }
        }

        return $this->app()->$name;
    }
}
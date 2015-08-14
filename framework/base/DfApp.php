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
     * Application web path
     * Example: localhost
     * @var string
     */
    private static $appPath;
    /**
     * Runtime path
     * Example: localhost
     * @var string
     */
    private static $runtimePath;
    /**
     * Application
     * @var DfApp
     */
    private static $app;
    /**
     * Logger
     * @var DfLogger
     */
    public $logger;
    /**
     * Timer
     * @var DfTimer
     */
    public $timer;
    /**
     * Router
     * @var DfMVC
     */
    public $router;
    /**
     * Mysql
     * @var DfMysql
     */
    public $mysql;

    /**
     * Initialization process
     */
    public static function init($runtimePath = __DIR__)
    {
        DfApp::app()->timer = new DfTimer();
        DfApp::app()->timer->start();

        DfApp::app()->router = new DfMVC();

        DfApp::$runtimePath = $runtimePath;
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
            static::$appPath = trim($config['app_path'], "/");
        }

        if (isset($config['components'])) {
            if (isset($config['components']['mysql'])) {
                DfApp::app()->mysql = new DfMysql($config['components']['mysql']);
            }
        }

        if (isset($config['logger']['path'])) {
            DfApp::app()->logger = new DfLogger($config['logger']['path']);
        } else {
            DfApp::app()->logger = new DfLogger();
        }

        if (isset($config['errors'])) {
            if (isset($config['errors']['display'])) {
                switch ($config['errors']['display']) {
                    case true:
                        ini_set('display_errors', 1);
                        ini_set('display_startup_errors', 1);
                        error_reporting(isset($config['errors']['level']) ? $config['errors']['level'] : -1);
                        break;
                    case false:
                    default:
                        ini_set('display_errors', 0);
                        ini_set('display_startup_errors', 1);
                        error_reporting(0);
                        break;
                }
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
        return ($slash == true ? static::$appPath . "/" : static::$appPath);
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
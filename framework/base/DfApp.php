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
     * Example: C:\Users\Nikita Fedoseev\Dropbox\Work\Programming\PHP\projects\framework
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
        set_error_handler(create_function('$c, $m, $f, $l', 'throw new DfPHPException($m, $c, $f, $l);'), E_ALL & ~E_NOTICE);
        DfApp::app()->router = new DfMVC();
        DfApp::app()->router->execute();
    }

    /**
     * Config Reading
     * @param $config
     */
    private static function configRead($config)
    {
        if (isset($config['app_path'])) {
            static::$appPath = trim($config['app_path'], '/');
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

        if (isset($config['router']['default'])) {
            if (isset($config['router']['default']['controller'])) {
                DfApp::app()->router->controller = $config['router']['default']['controller'];
            }

            if (isset($config['router']['default']['action'])) {
                DfApp::app()->router->action = $config['router']['default']['action'];
            }

            if (isset($config['router']['default']['id'])) {
                DfApp::app()->router->id = $config['router']['default']['id'];
            }
        }
    }

    /**
     * Returning app web path
     * @param bool $slash
     * @return string
     */
    public static function getPath($slash = false)
    {
        return ($slash == true ? static::$appPath . '/' : static::$appPath);
    }

    /**
     * Returning app path
     * @param bool $slash
     * @return string
     */
    public static function getRuntimePath($slash = false)
    {
        return ($slash == true ? static::$runtimePath . '/' : static::$runtimePath);
    }

    /**
     * Return current framework version
     * @return string
     */
    public static function getVersion()
    {
        return '0.2.1-dev';
    }
}
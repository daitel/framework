<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace df\base;

use DfBaseApp;
use df\logging\Logger;
use df\data\DbConnection;
use df\utils\Timer;

/**
 * Application is base class
 *
 * Application class provide main functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.2.1
 */
class Application
{
    /**
     * Application web path
     * Example: localhost
     * @var string
     */
    private static $applicationPath;
    /**
     * Runtime path
     * Example: C:\Users\Nikita Fedoseev\Dropbox\Work\Programming\PHP\projects\framework
     * @var string
     */
    private static $runtimePath;
    /**
     * Application
     * @var Application
     */
    private static $application;
    /**
     * Logger
     * @var Logger
     */
    public $logger;
    /**
     * Timer
     * @var Timer
     */
    public $timer;
    /**
     * Router
     * @var MVC
     */
    public $router;
    /**
     * Mysql
     * @var DbConnection
     */
    public $db;

    /**
     * Initialization process
     */
    private static function init()
    {
        self::app()->timer = new Timer();
        self::app()->timer->start();
    }

    /**
     * Application copy for non-static call
     * @return Application
     */
    public static function app()
    {
        if (self::$application === null) {
            self::$application = new Application;
        }

        return self::$application;
    }

    /**
     * Start Application
     * @param array $config
     * @param string $directory
     * @throws SetupException
     */
    public static function start($config = [], $directory = '')
    {
        self::init();

        self::prepareRuntimePath($directory);

        try {
            if (empty(self::$runtimePath)) {
                throw new SetupException("No defined RuntimePath");
            }

            self::app()->router = new MVC();
            self::configRead($config);
            ErrorHandler::registerHandlers();
            self::app()->router->process();

            try {
                self::app()->router->call();
            } catch (Exception $ex) {
                ErrorHandler::exception($ex);
            }
        } catch (Exception $ex) {
            ErrorHandler::exception($ex);
        }
    }

    /**
     * Prepare runtime path
     */
    private static function prepareRuntimePath($subFolder = '')
    {
        self::$runtimePath = self::getMainDirectory() . (!empty($subFolder) ? "/$subFolder" : "");
    }

    /**
     * Get main directory
     * @return string
     */
    private static function getMainDirectory()
    {
        return realpath(dirname(DfBaseApp::getFramework()));
    }

    /**
     * Config Reading
     * @param $config
     */
    private static function configRead($config)
    {
        if (isset($config['application_path'])) {
            self::$applicationPath = trim($config['application_path'], '/');
        }

        if (isset($config['components'])) {
            if (isset($config['components']['db'])) {
                self::app(
                )->db = new DbConnection($config['components']['db']['link'], $config['components']['db']['user'], $config['components']['db']['password']);
            }
        }

        if (isset($config['logger']['path'])) {
            self::app()->logger = new Logger($config['logger']['path']);
        } else {
            self::app()->logger = new Logger();
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
                        ini_set('display_startup_errors', 0);
                        error_reporting(0);
                        break;
                }
            }

            if (isset($config['errors']['debug'])) {
                ErrorHandler::$debug = $config['errors']['debug'];
            }

            if (isset($config['errors']['error_call'])) {
                ErrorHandler::$errorCall = $config['errors']['error_call'];
            }
        }


        if (isset($config['router']['default'])) {
            if (isset($config['router']['default']['controller'])) {
                self::app()->router->controller = $config['router']['default']['controller'];
            }

            if (isset($config['router']['default']['action'])) {
                self::app()->router->action = $config['router']['default']['action'];
            }

            if (isset($config['router']['default']['id'])) {
                self::app()->router->id = $config['router']['default']['id'];
            }
        }
    }

    /**
     * Returning Application path
     * @param bool $slash
     * @return string
     */
    public static function getRuntimePath($slash = false)
    {
        return ($slash == true ? self::$runtimePath . '/' : self::$runtimePath);
    }

    /**
     * Returning Application web path
     * @param bool $slash
     * @return string
     */
    public static function getPath($slash = false)
    {
        return ($slash == true ? self::$applicationPath . '/' : self::$applicationPath);
    }

    /**
     * Return current framework version
     * @return string
     */
    public static function getVersion()
    {
        return '0.3.0-dev';
    }
}
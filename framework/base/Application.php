<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace daitel\framework\base;

use DfBaseApp;
use daitel\framework\logging\Logger;
use daitel\framework\data\DbConnection;
use daitel\framework\utils\Timer;

/**
 * Application is base class
 *
 * Application class provide main functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.2.1
 */
class Application extends Component
{
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
     * @var string
     */
    public $applicationClass = 'application\\';
    /**
     * @var array
     */
    public $applicationPath = ['', 3];
    /**
     * Application web path
     * @var string
     */
    public $applicationUrl = '';
    /**
     * Runtime path
     * @var string
     */
    private $runtimePath;

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
     * @throws SetupException
     */
    public static function start($config)
    {
        self::init();

        if (empty($config)) {
            throw new SetupException("Empty config");
        }

        self::configRead($config);

        self::prepareRuntimePath(DfBaseApp::getFramework());

        ErrorHandler::registerHandlers();

        try {
            self::app()->router->process();
            self::app()->router->call();

            echo self::app()->router->result;

        } catch (Exception $ex) {
            ErrorHandler::exception($ex);
        }
    }

    /**
     * Prepare runtime path
     */
    private static function prepareRuntimePath($path)
    {
        for ($i = 0; $i < self::app()->applicationPath[1]; $i++) {
            $path = dirname($path);
        }

        $path .= '/' . self::app()->applicationPath[0];

        self::app()->runtimePath = realpath($path);

        DfBaseApp::addClass(self::app()->applicationClass, self::app()->runtimePath);
    }

    /**
     * Config Reading
     * @param $config
     */
    private static function configRead($config)
    {
        self::app()->setConfigValues($config);

        if (isset($config['components'])) {
            if (isset($config['components']['db'])) {
                self::app()->db = new DbConnection($config['components']['db']);
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

    }

    /**
     * Returning Application path
     * @param bool $slash
     * @return string
     */
    public static function getRuntimePath($slash = false)
    {
        return ($slash == true ? self::app()->runtimePath . '/' : self::app()->runtimePath);
    }

    /**
     * Returning Application web path
     * @param bool $slash
     * @return string
     */
    public static function getUrl($slash = false)
    {
        return ($slash == true ? self::app()->applicationUrl . '/' : self::app()->applicationUrl);
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
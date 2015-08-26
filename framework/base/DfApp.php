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
     * @var DfDbConnection
     */
    public $db;

    /**
     * Initialization process
     */
    public static function init()
    {
        DfApp::app()->timer = new DfTimer();
        DfApp::app()->timer->start();
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
     * @param string $directory
     * @throws DfSetupException
     */
    public static function start($config = [], $directory = '')
    {
        static::prepareRuntimePath($directory);

        try {
            if (empty(DfApp::$runtimePath)) {
                throw new DfSetupException("No defined RuntimePath");
            }

            DfApp::app()->router = new DfMVC();
            static::configRead($config);
            DfErrorHandler::registerHandlers();
            DfApp::$app->router->process();

            try {
                DfApp::app()->router->call();
            } catch (DfException $ex) {
                DfErrorHandler::exception($ex);
            }
        } catch (DfException $ex) {
            DfErrorHandler::exception($ex);
        }
    }

    /**
     * Prepare runtime path
     */
    private static function prepareRuntimePath($subFolder = '')
    {
        static::$runtimePath = static::getMainDirectory() . (!empty($subFolder) ? "/$subFolder" : "");
    }

    /**
     * Get main directory
     * @return string
     */
    private static function getMainDirectory()
    {
        return realpath(dirname(dirname(__DIR__)));
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
            if (isset($config['components']['db'])) {
                DfApp::app()->db = new DfDbConnection($config['components']['db']['link'],$config['components']['db']['user'], $config['components']['db']['password']);
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
                        ini_set('display_startup_errors', 0);
                        error_reporting(0);
                        break;
                }
            }

            if (isset($config['errors']['debug'])) {
                DfErrorHandler::$debug = $config['errors']['debug'];
            }

            if (isset($config['errors']['error_call'])) {
                DfErrorHandler::$errorCall = $config['errors']['error_call'];
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
     * Returning app path
     * @param bool $slash
     * @return string
     */
    public static function getRuntimePath($slash = false)
    {
        return ($slash == true ? static::$runtimePath . '/' : static::$runtimePath);
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
     * Return current framework version
     * @return string
     */
    public static function getVersion()
    {
        return '0.2.1';
    }
}
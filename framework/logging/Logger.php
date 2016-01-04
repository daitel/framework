<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace daitel\framework\logging;

use daitel\framework\data\Sql;

/**
 * Logger is logging class
 *
 * Logger class provide logger functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.1.3
 */
class Logger
{
    /*
     * Types
     */
    const TYPE_INFO = 'info';
    const TYPE_WARNING = 'warning';
    const TYPE_ERROR = 'error';
    /*
     * Levels
     */
    const LEVEL_LOG = 'log';
    const LEVEL_DEBUG = 'debug';
    const LEVEL_USER = 'user';
    const LEVEL_ADMIN = 'admin';
    /**
     * Component name
     * @var string
     */
    public $componentName = 'logger';
    /**
     * Component name
     * @var string
     */
    public $path;
    /**
     * logData Array
     * @var array
     */
    private $logData = array();

    /**
     * __construct
     * @param string $path
     */
    public function __construct($path = 'log.txt')
    {
        $this->path = $path;
    }

    /**
     * Add Log record
     * @param string $component
     * @param string $location
     * @param string $error
     * @param string $type
     * @param string $level
     */
    public function log($component, $location, $error, $type = Logger::TYPE_INFO, $level = Logger::LEVEL_LOG)
    {
        $this->logData[] = [
            'time' => $this->getLogDate(),
            'type' => $type,
            'component' => $component,
            'location' => (empty($location) ? getenv(
                        'REMOTE_ADDR'
                    ) . ':' . (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '')
                    : $location),
            'error' => $error,
            'level' => $level
        ];
    }

    /**
     * Return current date for log record
     * @return string
     */
    private function getLogDate()
    {
        return Sql::datetime();
    }

    /**
     * Get logData By Type
     * Types:
     * - TYPE_INFO
     * - TYPE_WARNING
     * - TYPE_ERROR
     * @param string $type
     * @return array
     */
    public function getLogDataByType($type)
    {
        return $this->getLogDataBy('type', $type);
    }

    /**
     * Get log data by key and value
     * @param string $key
     * @param string $value
     * @return array|bool
     */
    private function getLogDataBy($key, $value)
    {
        $return = array();
        foreach ($this->logData as $error) {
            if ($error[$key] == $value) {
                $return[] = $error;
            }
        }
        return (!empty($return) ? $return : false);
    }

    /**
     * Get logData by Component
     * @param string $component
     * @return array
     */
    public function getLogDataByComponent($component)
    {
        return $this->getLogDataBy('component', $component);
    }

    /**
     * Save log to file
     * @param string $key
     * @param string $value
     */
    public function save($key = '', $value = '')
    {
        $logger_file = new LoggerFile($this->path);

        if ($key && $value) {
            $logger_array = $this->getLogDataBy($key, $value);
        } else {
            $logger_array = $this->logData;
        }

        $logger_file->write($logger_array);
    }

    /**
     * Get logData By level
     * Levels:
     * - LEVEL_LOG
     * - LEVEL_DEBUG
     * - LEVEL_USER
     * - LEVEL_ADMIN
     * @param string $level
     * @return array|bool
     */
    public function getLogDataByLevel($level)
    {
        return $this->getLogDataBy('type', $level);
    }

    /**
     * Get Records
     * @return array
     */
    public function getLogData()
    {
        return $this->logData;
    }

    /**
     * Setter
     * @param array $logData
     */
    public function setLogData($logData = array())
    {
        $this->logData = array_merge($this->logData, $logData);
    }
}
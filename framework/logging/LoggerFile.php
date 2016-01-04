<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace daitel\framework\logging;

use daitel\framework\base\Component;
use daitel\framework\utils\File;

/**
 * LoggerFile is logging class
 *
 * LoggerFile class provide functions for write log data into log file
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.logging
 * @since 0.1.3
 */
class LoggerFile extends Component
{
    /**
     * Log file
     * @var File
     */
    private $logFile;
    /**
     * Component name
     * @var string
     */
    public $componentName = 'LoggerFile';

    /**
     * Constructor of class
     * @param string $path
     */
    public function __construct($path)
    {
        $this->logFile = new File($path);
    }

    /**
     * Write log data process
     * @param array $log_data
     */
    public function write($log_data = array())
    {
        foreach ($log_data as $log) {
            $line = '';
            foreach ($log as $log_part) {
                if (!empty($line)) {
                    $line .= '|';
                }
                $line .= $log_part;
            }
            $this->writeLine($line);
        }
    }

    /**
     * Function for File write
     * @param string $text
     */
    private function writeLine($text)
    {
        $this->logFile->write($text);
    }
}
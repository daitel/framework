<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace df\base;

use Exception as Ex;

/**
 * Exception is class for handling exceptions
 *
 * Exception class provide error and exception handling functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.2.1
 */
class Exception extends Ex
{
    /**
     * __construct
     * @param string $message
     * @param int $errorLevel
     * @param string $errorFile
     * @param int $errorLine
     * @param Exception $previous
     */
    public function __construct($message, $errorLevel = 0, $errorFile = '', $errorLine = 0, $previous = null)
    {
        parent::__construct($message, $errorLevel, $previous);
        $this->file = !empty($errorFile) ? $errorFile : $this->getFile();
        $this->line = !empty($line) ? $line : $this->getLine();
    }
}
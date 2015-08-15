<?php
/**
 * DfException is class for handling exceptions
 *
 * DfException class provide error and exception handling functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.base
 * @since 0.2.1
 */
class DfException extends Exception
{
    /**
     * __construct
     * @param string $message
     * @param int $errorLevel
     * @param string $errorFile
     * @param int $errorLine
     */
    public function __construct($message, $errorLevel = 0, $errorFile = '', $errorLine = 0)
    {
        parent::__construct($message, $errorLevel);
        $this->file = $errorFile;
        $this->line = $errorLine;
    }
}
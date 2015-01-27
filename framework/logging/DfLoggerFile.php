<?php
/**
 * DfLoggerFile is logging class
 *
 * DfLoggerFile class provide functions for write log data into log file
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.logging
 * @since 0.1.3
 */
class DfLoggerFile extends DfComponent
{
    /**
     * Log file
     * @var DfFile
     */
    private $log_file;

    private $errors;

    /**
     * Component name
     * @var string
     */
    private $component_name = 'LoggerFile';

    /**
     * Constructor of class
     *
     * @param string $path
     */
    public function __construct($path)
    {
        $this->log_file = new DfFile($path);
    }

    public function write($log_data = array()){
        foreach($log_data as $log){
            $line = '';
            foreach($log as $log_part){
                if(!empty($line)){
                    $line .= '|';
                }
                $line .= $log_part;
            }
            $this->writeLine($line);
        }
    }

    /**
     * Interface for DfFile write
     * @param string $text
     */
    private function writeLine($text)
    {
        $this->log_file->write($text);
    }
}
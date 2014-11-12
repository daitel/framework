<?php
/**
 * Daitel Framework
 * Logger Class
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 *
 */

class DfLogger extends DfComponent
{

    /**
     * Log file
     * @var DfFile
     */
    private $log_file;

    /**
     * Component name
     *
     * @see DfComponent
     * @see DfErrors
     *
     * @var string
     */
    private $component_name = 'logger';

    /**
     * Constructor of class
     *
     * @param string $path
     */
    public function __construct($path)
    {
        $this->log_file = new DfFile($path);
    }

    /**
     * Write errors array
     *
     * @param array $errors
     */
    public function writeErrors($errors = array())
    {
        foreach ($errors as $type => $errors_type) {
            foreach ($errors_type as $component => $errors_component) {
                foreach ($errors_component as $time => $errors_time) {
                    foreach ($errors_time as $location => $error) {
                        $this->writeLine("[$time][$type][$component] | $error [$location]");
                    }
                }
            }
        }
    }

    /**
     * Interface for DfFile write
     *
     * @param string $text
     */
    private function writeLine($text)
    {
        $this->log_file->write($text);
    }
}
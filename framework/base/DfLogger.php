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
     * Log file path
     * @var string
     */
    private $path;
    /**
     * Component name
     *
     * @see DfComponent
     * @see DfErrors
     *
     * @var string
     * @var string
     */
    private $component_name = 'logger';

    /**
     * Constructor of class
     *
     * @param $path
     */
    public function __construct($path)
    {
        $this->file = $path;
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
     * Interface for DfFile::writeLine
     *
     * @see DfFile
     *
     * @param $text
     */
    private function writeLine($text)
    {
        if (!DfFile::write($this->path, $text)) {
            $this->addError('danger', $this->component_name, "unable to DfFile::writeLine in log file");
        }
    }
}
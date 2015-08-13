<?php
/**
 * Daitel Framework
 * Class for standard component
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 */
class DfComponent
{
    /**
     * Component Name
     * @var string
     */
    public $componentName = '';

    /**
     * Log
     * @param $error
     * @param $location
     * @param string $type
     * @param string $level
     */
    public function log($error, $location, $type = DfLogger::TYPE_INFO, $level = DfLogger::LEVEL_LOG)
    {
        DfApp::app()->logger->log($this->componentName, $error, $location, $type, $level);
    }
}
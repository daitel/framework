<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace df\base;

use DfApp;
use df\logging\Logger;

/**
 * Class for standard component
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 */
class Component
{
    /**
     * Component Name
     * @var string
     */
    public $componentName = '';

    /**
     * Log
     * @param string $error
     * @param $location
     * @param string $type
     * @param string $level
     */
    public function log($error, $location, $type = Logger::TYPE_INFO, $level = Logger::LEVEL_LOG)
    {
        DfApp::app()->logger->log($this->componentName, $error, $location, $type, $level);
    }
}
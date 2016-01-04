<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace daitel\framework\base;

use DfApp;
use daitel\framework\logging\Logger;

/**
 * Class for standard component
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 */
class Component implements Configurable
{
    /**
     * Component Name
     * @var string
     */
    public $componentName = '';

    /**
     * Construct
     * @param $config
     */
    public function __construct($config = [])
    {
        $this->setConfigValues($config);
        $this->afterConstruct();
    }

    /**
     * Start component, calls after construct
     */
    public function afterConstruct()
    {
    }

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

    /**
     * Set config value
     * @param mixed $var
     * @param mixed $value
     */
    public function setConfigValue($var, $value)
    {
        if (isset($this->$var)) {
            $this->$var = $value;
        }
    }

    /**
     * Set config values from array
     * @param $array
     * @return mixed
     */
    public function setConfigValues($array)
    {
        if (!empty($array)) {
            foreach ($array as $var => $value) {
                $this->setConfigValue($var, $value);
            }
        }
    }
}
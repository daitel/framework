<?php
/**
 * DfLogger is logging class
 *
 * DfLogger class provide logger functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.logging
 * @since 0.1.3
 */
class DfLogger
{
    /**
     * Component name
     * @see DfComponent
     * @var string
     */
    private $component_name = 'Logger';
    /**
     * LogData Array
     * @var array
     */
    private $LogData = array();

    /**
     * Add Log record
     * @param $component
     * @param $location
     * @param $error
     * @param string $type
     * @param string $level
     */
    public function log($component, $location, $error, $type = 'info', $level = 'log')
    {
        $this->LogData[] = array(
            'time' => $this->getLogDate(),
            'type' => $type,
            'component' => $component,
            'location' => $location,
            'error' => $error,
            'level' => $level
        );
    }

    /**
     * Return current date for log record
     * @return bool|string
     */
    private function getLogDate()
    {
        return date("d-m-Y H:i:s");
    }

    /**
     * Get LogData By Type
     * @param string $type
     * @return array
     */
    public function getLogDataByType($type)
    {
        return $this->getLogDataBy('type', $type);
    }

    /**
     * Get log data by key and value
     * @param $key
     * @param $value
     * @return array|bool
     */
    private function getLogDataBy($key, $value)
    {
        $return = array();
        foreach ($this->LogData as $error) {
            if ($error[$key] == $value) {
                $return[] = $error;
            }
        }
        return (!empty($return) ? $return : false);
    }

    /**
     * Get LogData by Component
     * @param string $component
     * @return array
     */
    public function getLogDataByComponent($component)
    {
        return $this->getLogDataBy('component', $component);
    }

    /**
     * Save log to file
     * @param $path
     * @param string $key
     * @param string $value
     */
    public function save($path, $key = '', $value = '')
    {
        $logger_file = new DFLoggerFIle($path);

        if ($key && $value) {
            $logger_array = $this->getLogDataBy($key, $value);
        } else {
            $logger_array = $this->LogData;
        }

        $logger_file->write($logger_array);
    }

    /**
     * Get LogData By level
     * Level types:
     * - log
     * - debug
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
        return $this->LogData;
    }

    /**
     * Setter
     * @param array $LogData
     */
    public function setLogData($LogData = array())
    {
        foreach ($LogData as $error) {
            $this->LogData[] = $error;
        }
    }
}
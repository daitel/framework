<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace daitel\framework\data;

/**
 * Record is data working class
 *
 * Record create for oop work with data
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.2.1
 */
class Record
{
    /**
     * Data array
     * @var array
     */
    protected $attributes = [];

    /**
     * Construct
     * @param array $data
     */
    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->setVariables();
        }
    }

    /**
     * Set Variables
     * @param array $data
     */
    protected function setVariables($data = [])
    {
        foreach ($data as $name => $value) {
            $this->$name = $value;
        }
    }

    /**
     * Magic __get for get value by name from data array
     * @param string $name
     * @return string
     */
    public function __get($name)
    {
        return (isset($this->attributes[$name]) ? $this->attributes[$name] : '');
    }

    /**
     * Magic __set for set value in data array
     * @param string $name
     * @param mixed $value
     * @return string
     */
    public function __set($name, $value)
    {
        if (!is_int($name)) {
            $this->attributes[$name] = $value;
        }
    }
} 
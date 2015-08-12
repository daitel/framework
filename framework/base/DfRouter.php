<?php
/**
 * DfRouter is base routing class
 *
 * DfRouter class provide routing function
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.base
 * @since 0.2.1
 */
class DfRouter
{
    /**
     * Elements
     * @var array
     */
    public $elements = [];
    /**
     * Variables
     * @var array
     */
    public $variables = [];
    /**
     * Path
     * @var string
     */
    public $path = "";

    /**
     * Init
     */
    public function init()
    {
        if ($this->path == '') {
            static::setPath((isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : ''));
        }

        static::decodePath();
    }

    /**
     * Set Url path
     * @param $path
     */
    private function setPath($path)
    {
        $this->path = ltrim($path, '/');
    }

    /**
     * Decode Path
     */
    private function decodePath()
    {
        $general_elements = explode("?", $this->path);
        static::setElements($general_elements);
        static::setVariables($general_elements);
    }

    /**
     * Set Elements
     * @param $general_elements
     */
    private function setElements($general_elements)
    {
        if (isset($general_elements[0])) {
            $this->elements = explode("/", $general_elements[0]);
        }
    }

    /**
     * Set Variables
     * @param $general_elements
     */
    private function setVariables($general_elements)
    {
        if (isset($general_elements[1])) {
            $variables = explode("&", $general_elements[1]);

            foreach ($variables as $var) {
                list($name, $value) = explode("=", $var);
                $this->variables[$name] = $value;
            }
        }
    }
} 
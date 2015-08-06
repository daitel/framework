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
    public static $elements = [];
    /**
     * Variables
     * @var array
     */
    public static $variables = [];
    /**
     * Path
     * @var string
     */
    public static $path = "";

    /**
     * Init
     */
    public static function init()
    {
        if (static::$path == '') {
            static::setPath((isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : ''));
        }

        static::decodePath();
    }

    /**
     * Set Url path
     * @param $path
     */
    private static function setPath($path)
    {
        static::$path = ltrim($path, '/');
    }

    /**
     * Decode Path
     */
    private static function decodePath()
    {
        $general_elements = explode("?", static::$path);
        static::setElements($general_elements);
        static::setVariables($general_elements);
    }

    /**
     * Set Elements
     * @param $general_elements
     */
    private static function setElements($general_elements)
    {
        if (isset($general_elements[0])) {
            static::$elements = explode("/", $general_elements[0]);
        }
    }

    /**
     * Set Variables
     * @param $general_elements
     */
    private static function setVariables($general_elements)
    {
        if (isset($general_elements[1])) {
            $variables = explode("&", $general_elements[1]);

            foreach ($variables as $var) {
                list($name, $value) = explode("=", $var);
                static::$variables[$name] = $value;
            }
        }
    }
} 
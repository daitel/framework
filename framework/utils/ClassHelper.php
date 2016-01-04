<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace daitel\framework\utils;

/**
 * Class ClassHelper
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.3.0
 */
class ClassHelper {
    /**
     * Get class name from full namespace path
     *
     * @since 0.3.0
     * @param string $class
     * @return string
     */
    public static function getName($class){
        $classParts = explode("\\", $class);
        $className = $classParts[count($classParts) - 1];

        return $className;
    }

    /**
     * Get class name from object
     *
     * @since 0.3.0
     * @param $class
     * @return mixed
     */
    public static function getNameFromClass($class){
        return self::getName(get_class($class));
    }
}
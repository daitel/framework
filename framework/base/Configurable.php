<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace daitel\framework\base;

/**
 * Configurable is class for provide config options to Component
 *
 * Configurable provide function config operations
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.2.1
 */
interface Configurable {
    /**
     * Set config value
     * @param mixed $var
     * @param mixed $value
     */
    public function setConfigValue($var, $value);

    /**
     * Set config values from array
     * @param $array
     * @return mixed
     */
    public function setConfigValues($array);
} 
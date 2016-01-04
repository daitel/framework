<?php
/**
 * @link https://github.com/daitel/framework
 */

namespace daitel\framework;

/**
 * Daitel Framework | Base File
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.2.1
 */
class DfBase
{
    /**
     * Array with namespace => root directories
     * [0] - path
     * [1] - if false add framework path until classes path
     *
     * @var array
     */
    private static $classes = [
        'daitel\framework\\' => ['', false]
    ];

    /**
     * Core directory
     * @var string
     */
    private static $dir;

    /**
     * Add class to autoload
     * @param $namespace
     * @param $path
     */
    public static function addClass($namespace, $path)
    {
        self::$classes[$namespace] = [$path, true];
    }

    /**
     * AutoLoader
     * @param string $class
     */
    public static function autoloader($class)
    {
        foreach (self::$classes as $prefix => $base_dir) {
            if (!$base_dir[1]) {
                $base_dir[0] = self::getFramework() . $base_dir[0];
            }

            self::loadClass($prefix, $class, $base_dir[0]);
        }
    }

    private static function loadClass($prefix, $class, $base_dir)
    {
        $len = strlen($prefix);
        if (strncmp($prefix, $class, $len) !== 0) {

        } else {
            $relative_class = substr($class, $len);

            $file = realpath($base_dir . "/" . str_replace('\\', '/', $relative_class) . '.php');

            if (file_exists($file)) {
                require $file;
            }
        }
    }

    /**
     * Get root directory of framework
     * @return string
     */
    public static function getFramework()
    {
        if (empty(self::$dir)) {
            self::$dir = __DIR__ . '/';
        }

        return self::$dir;
    }
}
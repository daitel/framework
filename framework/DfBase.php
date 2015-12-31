<?php
/**
 * @link https://github.com/daitel/framework
 */

namespace df;

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
     * TODO: add functions to work with that array
     * @var array
     */
    private static $classes = [
        'df\\' => 'framework',
        'application\\' => 'app',
        'test\\' => 'test/data/app'
    ];

    /**
     * Core directory
     * @var string
     */
    private static $dir;

    /**
     * AutoLoader
     * @param string $class
     */
    public static function autoloader($class)
    {
        foreach (self::$classes as $prefix => $base_dir) {
            $base_dir = self::getRoot().$base_dir.'/';

            $len = strlen($prefix);
            if (strncmp($prefix, $class, $len) !== 0) {

            }else{
                $relative_class = substr($class, $len);


                $file = $base_dir . str_replace('\\', '/', $relative_class) . '.php';

                if (file_exists($file)) {
                    require $file;
                }
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

    /**
     * Get root directory of application
     * @return string
     */
    public static function getRoot(){
        return dirname(self::getFramework()).'/';
    }
}
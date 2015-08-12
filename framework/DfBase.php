<?php
/**
 * Daitel Framework | Base File
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class DfBase
{
    public static $framework_directory;
    public static $dir;
}

if (empty($dir)) {
    $dir = 'framework';
}

DfBase::$dir = $dir;

DfBase::$framework_directory = [];

foreach (scandir(DfBase::$dir) as $directory) {
    ($directory != "." && $directory != ".." && is_dir(
        DfBase::$dir . "/" . $directory
    ) ? DfBase::$framework_directory[] = $directory : "");
}

/**
 * Autoloader class
 * @param $class
 */
function autoloader($class)
{
    foreach (DfBase::$framework_directory as $directory) {
        $path = DfBase::$dir . "/" . $directory . "/" . $class . ".php";
        if (file_exists($path)) {
            include($path);
        }
    }
}

spl_autoload_register(
    'autoloader'
);

if (!empty($config) && !$config['error_reporting']) {
    error_reporting(0);
}

DfApp::init();

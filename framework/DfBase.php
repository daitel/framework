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
    /**
     * Framework Directory
     * @var array
     */
    public $framework_directory = [];
    /**
     * Core directory
     * @var
     */
    public $dir;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->dir = __DIR__;
        $this->registerAutoloader();
    }

    /**
     * Register Autoloader
     */
    private function registerAutoloader()
    {
        spl_autoload_register(
            [$this, 'autoloader']
        );
    }

    /**
     * AutoLoader
     * @param string $class
     */
    private function autoloader($class)
    {
        if (empty($this->framework_directory)) {
            $this->scanFrameworkDirectory();
        }

        foreach ($this->framework_directory as $directory) {
            $path = $this->dir . "/" . $directory . "/" . $class . ".php";
            if (file_exists($path)) {
                include($path);
            }
        }
    }

    /**
     * Make array of framework directory
     */
    private function scanFrameworkDirectory()
    {
        foreach (scandir($this->dir) as $directory) {
            ($directory != "." && $directory != ".." && is_dir(
                $this->dir . "/" . $directory
            ) ? $this->framework_directory[] = $directory : "");
        }
    }
}
define('DF_BASE_PATH', realpath(dirname(__FILE__)));

$DfBase = new DfBase();
DfApp::init(DF_BASE_PATH);
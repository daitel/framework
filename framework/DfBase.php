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
    public $frameworkDirectory = [];
    /**
     * Application Directory
     * @var array
     */
    public $applicationDirectory = [];
    /**
     * Core directory
     * @var
     */
    public $dir;
    /**
     * Scanning status
     * @var bool
     */
    private $scanStatus = false;

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
        if ($this->scanStatus === false) {
            $this->scanFrameworkDirectory();
            $this->scanApplicationDirectory();
            $this->scanStatus = true;
        }

        foreach (array_merge($this->frameworkDirectory, $this->applicationDirectory) as $directory) {
            $path = $directory . "/" . $class . ".php";
            if (file_exists($path)) {
                require($path);
            }
        }
    }

    /**
     * Make array of framework directory
     */
    private function scanFrameworkDirectory()
    {
        $this->scan($this->dir, 'frameworkDirectory');
    }

    private function scan($_directory, $variable)
    {
        foreach (scandir($_directory) as $directory) {
            ($directory != "." && $directory != ".." && is_dir(
                $_directory . "/" . $directory
            ) ? array_push($this->$variable, realpath($_directory . '/' . $directory)) : "");
        }
    }

    private function scanApplicationDirectory()
    {
        $this->scan(dirname($this->dir) . '/app', 'applicationDirectory');
    }
}

define('DF_BASE_PATH', realpath(dirname(__FILE__)));

$DfBase = new DfBase();
DfApp::init(DF_BASE_PATH);
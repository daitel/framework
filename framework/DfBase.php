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
     * Runtime Path
     * @var string
     */
    private $runtimePath;

    /**
     * __construct
     */
    public function __construct($runtimePath = '')
    {
        $this->dir = __DIR__;
        $this->runtimePath = $runtimePath;
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
        $this->scan(
            (!empty($this->runtimePath) ? $this->runtimePath : dirname($this->dir)) . '/' . 'app',
            'applicationDirectory'
        );
    }
}

$DfTestDir = (class_exists('DfTests') ? DfTests::$dataDir : '');

$DfBase = new DfBase($DfTestDir);

DfApp::init(realpath(dirname(__FILE__)));
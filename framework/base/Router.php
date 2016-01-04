<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace daitel\framework\base;

/**
 * Router is base routing class
 *
 * Router class provide routing function
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.2.1
 */
class Router
{
    /**
     * Path
     * @var array
     */
    public $path = [];
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
     * fragment
     * @var string
     */
    public $fragment;

    /**
     * __construct
     * @param string $path
     */
    public function __construct($path = '')
    {
        $this->processPath($path);
    }

    /**
     * Process Path
     * @param string $path
     */
    protected function processPath($path)
    {
        $this->setPath(($path !== '' ? $path : (isset($_SERVER['REQUEST_URI']) ? $_SERVER['REQUEST_URI'] : '')));
        if (!empty($this->path)) {
            $this->decodePath();
        }
    }

    /**
     * Set Url path
     * @param string $path
     */
    private function setPath($path)
    {
        $this->path = parse_url($path);
    }

    /**
     * Decode Path
     */
    private function decodePath()
    {
        $this->setElements();
        $this->setVariables();
        $this->setFragment();
    }

    /**
     * Set Elements
     */
    private function setElements()
    {
        $this->elements = (isset($this->path['path']) ? explode("/", ltrim($this->path['path'], '/')) : []);
    }

    /**
     * Set Variables
     */
    private function setVariables()
    {
        if (isset($this->path['query'])) {
            $query = explode("&", trim($this->path['query']));
            foreach ($query as $var) {
                list($name, $value) = explode("=", $var);
                $this->variables[$name] = $value;
            }
        }
    }

    /**
     * Set Fragment
     */
    private function setFragment()
    {
        $this->fragment = (isset($this->path['fragment']) ? $this->path['fragment'] : '');
    }
} 
<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace daitel\framework\base;

use DfApp;

/**
 * View is a view class
 *
 * View provide functions for templates and views
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.2.1
 */
class View
{
    /**
     * Application views path
     * @var string
     */
    public $viewsPath;
    /**
     * Application views template path
     * @var string
     */
    public $templatePath;
    /**
     * View include path
     * @var string
     */
    public $includePath;
    /**
     * Template view
     * @var string
     */
    public $templateView = 'index';
    /**
     * View Data Array
     * @var array
     */
    public $viewData = [];

    /**
     * Construct
     */
    public function __construct()
    {
        $this->viewsPath = DfApp::app()->getRuntimePath(true) . 'views/';
        $this->templatePath = $this->viewsPath . 'templates/';
    }

    /**
     * Render view with template
     * @param string $view
     * @param array $data
     * @param string $templateView
     */
    public function render($view, $data = [], $templateView = '')
    {
        $this->renderPage($view, (empty($templateView) ? $this->templateView : $templateView), $data);
    }

    /**
     * Render view without template
     * @param $view
     * @param $data
     */
    public function renderView($view, $data)
    {
        $this->renderPage($view, '', $data);
    }

    /**
     * Render Page
     * @param string $viewName
     * @param string $template
     * @param array $data
     */
    private function renderPage($viewName, $template = '', $data = [])
    {
        $this->viewData = $data;
        $this->includePath = $this->getViewPath($viewName);

        if (!empty($template)) {
            $templatePath = $this->templatePath . $template . '.php';

            include($templatePath);
        } else {
            include($this->includePath);
        }
    }

    /**
     * Get View Path
     * @param string $name
     * @return bool
     */
    private function getViewPath($name)
    {
        $locations = [''];
        !isset(DfApp::app()->router->controller) ? : $locations[] = DfApp::app()->router->controller;
        !isset(DfApp::app()->router->action) ? : $locations[] = DfApp::app()->router->action;

        return $this->findView($locations, $name);
    }

    /**
     * Find View
     * @param array $locations
     * @param string $name
     * @return bool
     */
    private function findView($locations = [], $name)
    {
        $viewPath = $this->viewsPath;
        $checks = [];

        foreach ($locations as $id => $location) {
            $viewPath .= (intval($id) <= 1 ? '' : '/') . $location;
            $checkPath = $viewPath . (intval($id) == 0 ? '' : '/') . $name . '.php';
            $checks[] = $checkPath;
        }

        foreach (array_reverse($checks, true) as $path) {
            if (file_exists($path)) {
                return $path;
            }
        }

        return false;
    }

    /**
     * Render Include
     */
    private function renderInclude()
    {
        if (!empty($this->includePath)) {
            include($this->includePath);
        } else {
            throw new NotFoundException("View path is not defined");
        }
    }
}
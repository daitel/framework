<?php
/**
 * DfView is a view class
 *
 * DfView provide functions for templates and views
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.base
 * @since 0.2.1
 */
class DfView
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

    public function __construct()
    {
        $this->viewsPath = DF_APP_PATH . '/app/views/';
        $this->templatePath = $this->viewsPath . 'templates/';
    }

    public function render($view, $data = [])
    {
        $this->renderPage($view, $this->templateView, $data);
    }

    private function renderPage($viewName, $template, $data = [])
    {
        $this->viewData = $data;

        $this->includePath = $this->getViewPath($viewName);
        $templatePath = $this->templatePath . $template . '.php';

        if (isset($templatePath)) {
            include($templatePath);
        }
    }

    /**
     * Get View Path
     * @param string $name
     * @return bool
     */
    private function getViewPath($name)
    {
        $locations = ['/'];
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

        foreach ($locations as $id => $location) {
            $viewPath .= ($id == 0 ? '' : '/') . $location;
            $checkPath = $viewPath . $name . '.php';
            if (file_exists($checkPath)) {
                return $checkPath;
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
            echo "Error with include";
        }
    }
}
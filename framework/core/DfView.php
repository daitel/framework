<?php
/**
 * DfModel is a model class
 *
 * DfModel provide functions for work with data
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.core
 * @since 0.2.1
 */
class DfView
{
    public $template_view = 'template';

    public function render($view, $data = [])
    {
        $this->renderPage($view, $this->template_view, $data);
    }

    private function renderPage($view, $template, $data = [])
    {
        if (!empty($data)) {
            extract($data);
        }

        $path = 'app/views/' . $view;

        include $template;
    }
}
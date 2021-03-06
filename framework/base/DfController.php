<?php
/**
 * DfController is a controller class
 *
 * DfController provide functions for work with models and views
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.base
 * @since 0.2.1
 */
abstract class DfController
{
    /**
     * @var DfView
     */
    public $view;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->view = new DfView();
    }

    /**
     * Action: Index
     */
    public function actionIndex()
    {

    }

    /**
     * Before action call function
     */
    public function beforeAction()
    {

    }

    /**
     * After action call function
     */
    public function afterAction()
    {

    }

    /**
     * Render Page
     * @param string $view
     * @param array $data
     */
    public function render($view, $data = [])
    {
        $this->view->render($view, $data);
    }
}
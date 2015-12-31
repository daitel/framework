<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace df\base;

/**
 * Controller is a controller class
 *
 * Controller provide functions for work with models and views
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.2.1
 */
abstract class Controller
{
    /**
     * @var View
     */
    public $view;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->view = new View();
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
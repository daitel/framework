<?php
/**
 * DfController is a controller class
 *
 * DfModel provide functions for work with models and views
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.core
 * @since 0.2.1
 */
class DfController
{
    /**
     * @var DfView
     */
    public $view;

    /**
     * __construct
     */
    function __construct()
    {
        $this->view = new DfView();
    }

    /**
     * Action: Index
     */
    function actionIndex()
    {

    }
}
<?php
/**
 * Daitel Framework
 * Basic Application Controller
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class ErrorController extends DfController
{
    /**
     * Action: Index
     * View Error
     * @see DfMVC
     * @see DfErrorHandler
     */
    public function actionIndex()
    {
        $this->render('renderError');
    }
}
<?php
/**
 * Daitel Framework
 * Basic Application Controller
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class HelloController extends DfController
{
    /**
     * Action: Index
     * This action render view with text by ID var or with 'Hello World'
     * @see DfMVC
     */
    public function actionIndex($text = 'Hello World')
    {
        $this->render('sayText', ['text' => $text]);
    }
}
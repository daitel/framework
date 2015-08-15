<?php
/**
 * Daitel Framework
 * Controller for test process
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class MainController extends DfController
{
    public function actionIndex($id)
    {
        $this->render('main', ['text' => $id]);
    }
}
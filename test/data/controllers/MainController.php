<?php
/**
 * @link https://github.com/daitel/framework
 */

namespace application\controllers;

use daitel\framework\base\Controller;
use application\models\Users;

/**
 * Daitel Framework
 * Controller for test process
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class MainController extends Controller
{
    public function actionIndex($id = 'default')
    {
        $data = Users::record()->create(['username' => 'daitel', 'email' => 'example321@example.com']);

        return $this->render('main', ['data' => $data]);
    }

    public function actionTest($id = 'main')
    {
        return $this->render($id, []);
    }
}
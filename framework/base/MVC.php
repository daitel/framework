<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace daitel\framework\base;

use DfApp;

/**
 * MVC is routing class for MVC pattern
 *
 * MVC class provide routing function
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.2.1
 */
class MVC extends Router
{
    /**
     * Controller Name
     * @var string
     */
    public $controller = 'main';
    /**
     * Action Name
     * @var string
     */
    public $action = 'index';
    /**
     * ID var
     * @var string|int
     */
    public $id = '';

    /**
     * __construct
     */
    public function __construct($path = '', $startNow = false)
    {
        $this->processPath($path);
        if ($startNow === true) {
            $this->process();
        }
    }

    /**
     * Start processing with elements
     */
    public function process()
    {
        $this->setElements();
    }

    /**
     * Set Variables
     */
    private function setElements()
    {
        if (!empty($this->elements)) {
            $elementsKeys = ['controller', 'action', 'id'];

            foreach ($elementsKeys as $id => $key) {
                $this->setElement($key, $id);
            }
        }
    }

    /**
     * Set Element
     * @param string $key
     * @param int $num
     */
    private function setElement($key, $num)
    {
        if (isset($this->$key) && !empty($this->elements[$num])) {
            $this->$key = $this->elements[$num];
        }
    }

    /**
     * Call Controller action by array
     * @param array $array
     */
    public function callByArray($array)
    {
        $this->call(
            (!empty($array['controller']) ? $array['controller'] : ''),
            (!empty($array['action']) ? $array['action'] : ''),
            (!empty($array['id']) ? $array['id'] : '')
        );
    }

    /**
     * Call Controller action
     * @param string $_controller
     * @param string $_action
     * @param string $_id
     */
    public function call($_controller = '', $_action = '', $_id = '')
    {
        $this->controller = (!empty($_controller)) ? $_controller : $this->controller;
        $this->action = (!empty($_action)) ? $_action : $this->action;
        $this->id = (!empty($_id)) ? $_id : $this->id;

        $this->execute();
    }

    /**
     * execute
     */
    private function execute()
    {
        if (empty(DfApp::app()->getRuntimePath())) {
            throw new SetupException("No defined RuntimePath");
        }

        $controllerName = "\\".DfApp::app()->applicationClass."controllers\\".ucwords($this->controller)."Controller";

        if (!class_exists($controllerName)) {
            throw new NotFoundException("Unable to find controller: {$this->controller}");
        }

        $_controller = new $controllerName;

        $actionName = 'action' . ucwords($this->action);

        if (!method_exists($_controller, $actionName)) {
            throw new NotFoundException("Unable to find action: {$this->controller}/{$this->action}");
        }

        call_user_func([$_controller, 'beforeAction']);

        if (!empty($this->id)) {
            call_user_func([$_controller, $actionName], $this->id);
        } else {
            call_user_func([$_controller, $actionName]);
        }

        call_user_func([$_controller, 'afterAction']);
    }
} 
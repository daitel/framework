<?php
/**
 * DfMVC is routing class for MVC pattern
 *
 * DfMVC class provide routing function
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.base
 * @since 0.2.1
 */
class DfMVC extends DfRouter
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
     * Call Controller action
     * @param string $_controller
     * @param string $_action
     * @param string $_id
     */
    public function call($_controller = '', $_action = '', $_id = '')
    {
        $controller = (!empty($_controller)) ? $_controller : $this->controller;
        $action = (!empty($_action)) ? $_action : $this->action;
        $id = (!empty($_id)) ? $_id : $this->id;

        $this->execute($controller, $action, $id);
    }

    /**
     * execute
     */
    private function execute($controller, $action, $id)
    {
        if (empty(DfApp::app()->getRuntimePath())) {
            throw new DfSetupException("No defined RuntimePath");
        }

        $controllerName = ucwords($controller) . 'Controller';
        $controllerPath = DfApp::app()->getRuntimePath(true) . "app/controllers/" . $controllerName . ".php";
        $actionName = 'action' . ucwords($action);

        if (!file_exists($controllerPath)) {
            throw new DfNotFoundException("Unable to find controller: $controller");
        }

        $_controller = new $controllerName;

        if (!method_exists($_controller, $actionName)) {
            throw new DfNotFoundException("Unable to find action: $controller/$action");
        }

        if (!empty($this->id)) {
            call_user_func(array($_controller, $actionName), $id);
        } else {
            call_user_func(array($_controller, $actionName));
        }
    }
} 
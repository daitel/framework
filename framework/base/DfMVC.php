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
    public function __construct($path = '')
    {
        $this->processPath($path);
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
        if (isset($this->$key) && isset($this->elements[$num])) {
            $this->$key = $this->elements[$num];
        }
    }

    /**
     *
     */
    public function execute()
    {
        if (!defined("DF_APP_PATH")) {
            return false;
        }

        $controllerName = ucwords($this->controller) . 'Controller';
        $controllerPath = DF_APP_PATH . "/app/controllers/" . $controllerName . ".php";
        $actionName = 'action' . ucwords($this->action);

        if (!file_exists($controllerPath)) {
            return false;
        }

        require_once $controllerPath;

        $controller = new $controllerName;

        if (!method_exists($controller, $actionName)) {
            return false;
        }

        call_user_func(array($controller, $actionName), $this->id);
        return true;
    }
} 
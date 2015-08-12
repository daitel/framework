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
     * @var string
     */
    public $controller;
    /**
     * @var string
     */
    public $action;
    /**
     * @var string|int
     */
    public $id;

    /**
     * Initialization
     */
    public function init()
    {
        parent::init();
        static::set();
    }

    /**
     * Set Variables
     */
    private function set()
    {
        if (isset($this->elements[0])) {
            $this->controller = $this->elements[0];
            if (isset($this->elements[1])) {
                $this->action = $this->elements[1];
                if (isset($this->elements[2])) {
                    $this->id = $this->elements[2];
                }
            }
        }
    }
} 
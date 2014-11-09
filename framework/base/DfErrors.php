<?php
/**
 * Daitel Framework
 * Class for work with Errors
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 *
 */

class DfErrors
{
    /**
     * Errors Array
     *
     * @var array
     */
    private $errors = array();

    /**
     * Setter
     *
     * @param array $errors
     */
    public function setErrors($errors)
    {
        $this->errors = $errors;
    }

    /**
     * Add Error
     *
     * @param string $type
     * @param string $component
     * @param string $error
     */
    public function addError($type, $component, $error)
    {
        $this->errors[$component][$type][getLogDate()][] = $error;
    }

    /**
     * Add Errors by Component
     * 
     * @param string $component
     * @param array $errors
     */
    public function addErrors($component, $errors = array())
    {
        if ($errors) {
            $this->errors[$component] = $errors;
        }
    }

    /**
     * Get Errors By Type
     * 
     * @param string $type
     *
     * @return array
     */
    public function getErrorsByType($type)
    {
        //$return = array();
        foreach ($this->errors as $errorsComponent) {
            if (isset($errorsComponent[$type])) {
                return $errorsComponent[$type];
            }
        }
    }

    /**
     * Get Errors by Component
     * 
     * @param string $component
     *
     * @return array
     */
    public function getErrorsByComponent($component)
    {
        return $this->errors[$component];

    }

    /**
     * Get Records
     * 
     * @return array
     */
    public function getErrors()
    {
        return $this->errors;
    }
}
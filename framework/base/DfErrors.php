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
    private $errors = array();

    function setErrors($errors)
    {
        $this->errors = $errors;
    }

    function addError($type, $component, $error)
    {
        $this->errors[$component][$type][getLogDate()][] = $error;
    }

    function addErrors($component, $errors = array())
    {
        if ($errors) {
            $this->errors[$component] = $errors;
        }
    }

    function getErrorsByType($type)
    {
        //$return = array();
        foreach ($this->errors as $errorsComponent) {
            if (isset($errorsComponent[$type])) {
                return $errorsComponent[$type];
            }
        }
    }

    function getErrorsByComponent($component)
    {
        return $this->errors[$component];

    }


    function getErrors()
    {
        return $this->errors;
    }
}
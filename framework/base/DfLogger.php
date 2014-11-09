<?php
/**
 * Daitel Framework
 * Logger Class
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 *
 */

class DfLogger extends DfComponent
{

    private $file;
    private $component_name = 'logger';

    function __construct($path)
    {
        $this->file = $path;
    }

    function read()
    {
        if (file_exists($this->file)) {
            return file_get_contents($this->file);
        } else {
            $this->addError('danger', $this->component_name, 'unable tp read file');
            return false;
        }
    }

    function writeErrors($errors = array())
    {
        foreach ($errors as $type => $errors_type) {
            foreach ($errors_type as $component => $errors_component) {
                foreach ($errors_component as $time => $errors_time) {
                    foreach ($errors_time as $error) {
                        $this->writeLine("[$time][$type][$component] | $error");
                    }
                }
            }
        }
    }

    function writeLine($text)
    {
        $fp = fopen($this->file, "a+");
        if ($fp) {
            fwrite($fp, $text . "\n");
        } else {
            $this->addError('danger', $this->component_name, 'unable to write line');
        }
        fclose($fp);
    }

    function clear()
    {
        $fp = fopen($this->file, "a+");
        if ($fp) {
            ftruncate($fp, 0);
        } else {
            $this->addError('danger', $this->component_name, 'unable to clear file');
        }
        fclose($fp);
    }
}
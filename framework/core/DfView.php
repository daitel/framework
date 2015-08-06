<?php
/**
 * DfModel is a model class
 *
 * DfModel provide functions for work with data
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.core
 * @since 0.2.1
 */
class DfView
{
    //public $template_view; // здесь можно указать общий вид по умолчанию.

    function generate($content_view, $template_view, $data = null)
    {
        /*
        if(is_array($data)) {
            // преобразуем элементы массива в переменные
            extract($data);
        }
        */

        include 'application/views/' . $template_view;
    }

    public function render($view, $data = []){
        if(!empty($data)){
            extract($data);
        }


    }
}
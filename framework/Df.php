<?php
/**
 * @link https://github.com/daitel/framework
 */

require __DIR__ . '/DfBase.php';

/**
 * Class DfBaseApp
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.2.2
 *
 */
class DfBaseApp extends \df\DfBase
{
    public static function autoload(){
        spl_autoload_register(['DfBaseApp', 'autoloader']);
    }
}

DfBaseApp::autoload();

require __DIR__ . '/DfApp.php';

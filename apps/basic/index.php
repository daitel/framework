<?php
/**
 * Daitel Framework
 * Basic Application
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
//define application directory path
define('DF_APP_PATH', realpath(dirname(__FILE__)));

//include framework
if (file_exists("../../framework/DfBase.php")) {
    require_once "../../framework/DfBase.php";
} elseif (file_exists("framework/DfBase.php")) {
    require_once "framework/DfBase.php";
} else {
    die("Unable to include framework");
}

//include config
require_once "app/config/config.php";
//start application
DfApp::start($config);
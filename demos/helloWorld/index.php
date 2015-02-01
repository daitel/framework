<?php
/**
 * Daitel Framework
 * helloWorld index file
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 */
require_once('app/framework/DfBase.php');

$controller = $_GET['controller'];

if ($controller) {

	if (file_exists("app/controllers/$controller.php")) {
		include("app/controllers/$controller.php");
	} else {
		include("app/controllers/404.php");
	}

} else {
	if (file_exists("app/controllers/main.php")) {
		include("app/controllers/main.php");
	}
}

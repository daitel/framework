<?php
/**
 * Daitel Framework
 * Phone Book main controller file
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 */

$data = $model_Book->getBook();

$page = [
	'title' => 'Main Page',
	'include_path' => 'app/views/main.php'
];
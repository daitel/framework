<?php
/**
 * Daitel Framework
 * Phone Book index file
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 */

//include configs
require_once('app/config/main.php');
require_once('app/config/db.php');

//include framework
require_once('app/framework/DfBase.php');

//include models
require_once('app/models/Book.php');

//location for log file class
$current_location = getenv('REMOTE_ADDR') . ':' . $_SERVER['REQUEST_URI'];

//setup DfLogger
$log->log('site', '','Hello World from application');

//setup models
$model_Book = new Book($db_config);

include('app/controllers/main.php');

include('app/views/template.php');
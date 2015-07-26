<?php
/**
 * Daitel Framework | Base File
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 *
 */
if (empty($dir)) {
	$dir = 'framework';
}

$modules = [
	'base' => [
		'base/DfTimer',
		'logging/DfLogger',
		'base/DfComponent',
		'base/DfFile',
		'logging/DfLoggerFile'
	],
	'db' => [
		'db/DfMysql',
		'db/DfSql',
		'db/DfActiveRecord',
		'db/DfTable'
	],
	'utils' => [
		'utils/DfConverter',
		'utils/DfResource'
	]
];

foreach ($modules as $module) {
	foreach ($module as $file) {
		$file_path = $dir . '/' . $file . '.php';
		if (file_exists($file_path)) {
			require($file_path);
		} else {
			die('Critical Error. Unable to include ' . $file_path);
		}
	}
}

if (!empty($config) && !$config['error_reporting']) {
	error_reporting(0);
}

$time_start = DfTimer_start();

$log = new DfLogger();


<?php
/**
 * Daitel Framework
 * Phone Book main template file
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 */
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title><?php echo $config['app_name'] ?> <?php echo $page['title']; ?></title>
</head>
<body>

<main>
	<h1><?php echo $page['title']; ?></h1>
	<?php
	if ($logs = $log->getLogDataByLevel('log')) {
		var_dump($logs);
	}
	if ($page['include_path']) {
		include($page['include_path']);
	}
	?>
</main>

<footer>
	<?php
	$page['time'] = DfTimer_stop($time_start);

	echo 'Page generate in ' . $page['time'] . ' sec';
	?>
</footer>

</body>
</html>
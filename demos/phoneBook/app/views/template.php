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
	<link rel="stylesheet" href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css" type="text/css">
</head>
<body>
<main>
<div class="container">
	<h1><?php echo $page['title']; ?></h1>
	<?php
	if ($logs = $log->getLogDataByLevel('error')) {
		var_dump($logs);
	}
	if ($page['include_path']) {
		include($page['include_path']);
	}
	?>
</div>
</main>
<footer>
	<div class="container">
	<?php
	$page['time'] = DfTimer_stop($time_start);

	echo 'Page generate in ' . $page['time'] . ' sec';
	?>
	</div>
</footer>

</body>
</html>
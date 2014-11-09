<?php
/**
 * Daitel Framework | Base File
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 *
 */

require_once('base/DfTimer.php');
require_once('base/DfErrors.php');
require_once('base/DfConverter.php');
require_once('base/DfComponent.php');
require_once('base/DfLogger.php');
require_once('base/DfMysql.php');
require_once('base/DfFile.php');

$errors = new DfErrors();
$time_start = DfTimer_start();

function getLogDate()
{
    return date("d-m-Y H:i:s");
}






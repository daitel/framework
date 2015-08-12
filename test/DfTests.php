<?php
/**
 * Daitel Framework
 * Main Test Class
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class DfTests
{
    public static $testDir = 'test/res_test/';
}

$files = glob(DfTests::$testDir . '*');
foreach ($files as $file) {
    if (is_file($file)) {
        unlink($file);
    }
}

include('framework/DfBase.php');
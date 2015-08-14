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
    /**
     * @var string
     */
    public static $testDir;

    /**
     * Start Tests functions
     * @param $path
     */
    public static function start($path)
    {
        DfTests::$testDir = $path;
        DfTests::clearDir();
    }

    /**
     * Clear resource directory for tests process
     */
    private static function clearDir()
    {
        if (!file_exists(DfTests::$testDir)) {
            mkdir(DfTests::$testDir, 0777, true);
        } else {
            $files = glob(DfTests::$testDir . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
    }
}

DfTests::start(__DIR__ . '\\runtime\\');

include('framework/DfBase.php');
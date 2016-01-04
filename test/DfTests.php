<?php
/**
 * @link https://github.com/daitel/framework
 */

/**
 * Main Test Class
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.2.1
 */
class DfTests
{
    /**
     * Test runtime
     * @var string
     */
    public static $testDir;
    /**
     * Data
     * @var string
     */
    public static $dataDir;
    /**
     * Config array
     * @var array
     */
    public static $config;

    /**
     * Start Tests functions
     * @param $path
     * @param $config
     */
    public static function start($path, $config = [])
    {
        self::$testDir = $path."/runtime/";
        self::$dataDir = $path."/data/";
        self::clearDir();

        self::$config = $config;
    }

    /**
     * Clear resource directory for tests process
     */
    private static function clearDir()
    {
        if (!file_exists(self::$testDir)) {
            mkdir(self::$testDir, 0777, true);
        } else {
            $files = glob(self::$testDir . '*');
            foreach ($files as $file) {
                if (is_file($file)) {
                    unlink($file);
                }
            }
        }
    }
}
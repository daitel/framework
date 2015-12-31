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
     * Start Tests functions
     * @param $path
     */
    public static function start($path)
    {
        self::$testDir = $path."/runtime/";
        self::$dataDir = $path."/data/";
        self::clearDir();
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

DfTests::start(__DIR__);
require dirname(__DIR__).'/framework/Df.php';
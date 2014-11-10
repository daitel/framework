<?php
/**
 * Daitel Framework
 * Class for file work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 *
 */

class DfFile extends DfComponent
{

    /**
     * Component name
     *
     * @see DfComponent
     * @see DfErrors
     * @var string
     */
    static $component_name = 'file';
    /**
     * @var resource
     */
    private static $file;

    /**
     * Get Contents of file
     *
     * @param string $file
     *
     * @return bool|string
     */
    public static function read($file)
    {
        if (file_exists($file)) {
            return file_get_contents($file);
        } else {
            parent::addError('danger', self::$component_name, "unable to read file($file)");
            return false;
        }
    }

    /**
     * Write some text to file
     * WARNING: Function truncate file before write
     *
     * @param string $file_path
     * @param string $text
     * @param bool
     *
     * @return bool
     */
    public static function write($file_path, $text, $truncate = false)
    {
        if(!$file_path || !$text){
            return false;
        }
        if (self::initFile($file_path)) {
            if($truncate){
                ftruncate(self::getFile(), 0);
            }
            fwrite(self::getFile(), $text . "\n");
            fclose(self::getFile());
            return true;
        } else {
            return false;
        }
    }

    /**
     * Init File(fopen)
     *
     * @param string $file_path
     * @param string $type
     *
     * @return bool
     */
    private static function initFile($file_path, $type = 'a+')
    {
        $file_worker = fopen($file_path, $type);
        if ($file_worker) {
            self::setFile($file_worker);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set FileWorker
     *
     * @param resource $file
     */
    private static function setFile($file)
    {
        self::$file = $file;
    }

    /**
     * Get FileWorker
     *
     * @return resource
     */
    private static function getFile()
    {
        return self::$file;
    }
}
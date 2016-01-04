<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace daitel\framework\utils;

use daitel\framework\base\Component;

/**
 * Daitel Framework
 * Class for file work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 *
 */
class File extends Component
{
    /**
     * Component name
     *
     * @see Component
     * @see Errors
     * @var string
     */
    public $componentName = 'file';
    /**
     * @var resource
     */
    private $file;

    /**
     * Constructor
     * @param string $file
     */
    public function __construct($file)
    {
        $this->file = $file;
    }

    /**
     * Get Contents of file
     * @return string|false
     */
    public function read()
    {
        if (file_exists($this->file)) {
            return file_get_contents($this->file);
        } else {
            $this->log($this->componentName, $this->file, "unable to read file");
            return false;
        }
    }

    /**
     * Write text to file
     * @param string $text
     * @param bool $truncate
     * @return bool
     */
    public function write($text, $truncate = false)
    {
        if (!$text) {
            return false;
        }

        if ($this->initFile($this->file)) {
            if ($truncate) {
                ftruncate($this->file, 0);
            }

            fwrite($this->file, $text . "\n");
            fclose($this->file);
            return true;
        }

        return false;
    }

    /**
     * Init File
     * @param string $filePath
     * @param string $type
     * @return bool
     */
    private function initFile($filePath, $type = 'a+')
    {
        if (empty($filePath)) {
            return false;
        }

        $filePath = strval(str_replace("\0", "", $filePath));

        return ($this->file = fopen($filePath, $type)) ? true : false;
    }
}
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
    private $component_name = 'file';
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
            $this->log('danger', $this->component_name, $this->file, "unable to read file");
            return false;
        }
    }

    /**
     * Write some text to file
     * @param string $text
     * @param bool
     * @return bool
     */
    public function write($text, $truncate = false)
    {
        if (!$text) {
            return false;
        }
        if ($this->initFile($this->file)) {
            if ($truncate) {
                ftruncate($this->getFile(), 0);
            }
            fwrite($this->getFile(), $text . "\n");
            fclose($this->getFile());
            return true;
        } else {
            return false;
        }
    }

    /**
     * Init File(fopen)
     * @param string $file_path
     * @param string $type
     * @return bool
     */
    private function initFile($file_path, $type = 'a+')
    {
        if (empty($file_path)) {
            return false;
        }
        if ($file_worker = fopen($file_path, $type)) {
            $this->setFile($file_worker);
            return true;
        } else {
            return false;
        }
    }

    /**
     * Set FileWorker
     * @param resource $file
     */
    private function setFile($file)
    {
        $this->file = $file;
    }

    /**
     * Get FileWorker
     * @return resource
     */
    private function getFile()
    {
        return $this->file;
    }
}
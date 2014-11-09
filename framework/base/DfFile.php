<?php
/**
 * Daitel Framework
 * Functions for file work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 *
 */

function DfFile_write($file, $text)
{
    $fp = fopen($file, "a+");
    if ($fp) {
        ftruncate($fp, 0);
        fwrite($fp, $text . "\n");
    }
    fclose($fp);
}
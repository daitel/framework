<?php
/**
 * @link https://github.com/daitel/framework
 */
use daitel\framework\utils\Resource;

/**
 * Test Class for Resource work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.1.6
 */
class ResourceTest extends PHPUnit_Framework_TestCase
{
    public function testSet()
    {
        $data_js = "$(document).ready(function () {});";
        $data_css = ".hero {" .
            "background: #ffffff 0;" .
            "padding: 0 0 100px;" .
            "}";
        Resource::set('css', 'style.css', true);
        Resource::set('js', 'app.js', true);
        Resource::set('css', $data_css, false, '1');
        Resource::set('js', $data_js, false, '1');
    }

    public function testGet()
    {
        $this->assertEquals(
            '<link href="style.css" rel="stylesheet" type="text/css">' . "\n",
            Resource::get('css')
        );
        $this->assertEquals('<script src="app.js"></script>' . "\n", Resource::get('js'));
        $this->assertEquals(
            '<script>' . "\n" .
            '$(document).ready(function () {});' . "\n" .
            '</script>' . "\n",
            Resource::get('js', 1)
        );
        $this->assertEquals(
            '<style>' .
            '.hero {background: #ffffff 0;padding: 0 0 100px;}' .
            '</style>' . "\n",
            Resource::get('css', 1)
        );
    }
}
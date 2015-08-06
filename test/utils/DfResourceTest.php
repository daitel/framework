<?php
/**
 * Daitel Framework
 * Test Class for DfResource work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.1.6
 */
class DfResourceTest extends PHPUnit_Framework_TestCase
{
    /**
     * @covers DfResource::set
     */
    public function testSet()
    {
        $data_js = "$(document).ready(function () {});";
        $data_css = ".hero {" .
            "background: #ffffff 0;" .
            "padding: 0 0 100px;" .
            "}";
        DfResource::set('css', 'style.css', true);
        DfResource::set('js', 'app.js', true);
        DfResource::set('css', $data_css, false, '1');
        DfResource::set('js', $data_js, false, '1');
    }

    /**
     * @covers DfResource::get
     */
    public function testGet()
    {
        $this->assertEquals(
            '<link href="style.css" rel="stylesheet" type="text/css">' . "\n",
            DfResource::get('css')
        );
        $this->assertEquals('<script src="app.js"></script>' . "\n", DfResource::get('js'));
        $this->assertEquals(
            '<script>' . "\n" .
            '$(document).ready(function () {});' . "\n" .
            '</script>' . "\n",
            DfResource::get('js', 1)
        );
        $this->assertEquals(
            '<style>' .
            '.hero {background: #ffffff 0;padding: 0 0 100px;}' .
            '</style>' . "\n",
            DfResource::get('css', 1)
        );
    }
}
<?php
/**
 * Daitel Framework
 * Test Class for test db PDO connection work
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class DfDbConnectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @expectedException DfSetupException
     */
    public function testConstruct()
    {
        $db = new DfDbConnection('mysql:host=localhost;dbname=test1;charset=utf8', 'root', '');

        $db = new DfDbConnection('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');
        $this->assertTrue(is_object($db));
    }
}
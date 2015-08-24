<?php
/**
 * Daitel Framework
 * Test Class for test work with db table
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class DfTableTest extends PHPUnit_Framework_TestCase
{
    public function testNewTable()
    {
        $db = new DfDbConnection('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');
        $table = new DfTable($db, 'users');
        $this->assertTrue(is_object($table));
        $this->checkInsert($table);
        $this->checkUpdate($table);
    }

    /**
     * @param DfTable $table
     */
    public function checkInsert($table)
    {
        $this->assertTrue($table->insert(['username' => 'daitel', 'email' => 'example@example.com']));
        $this->assertTrue($table->insert([]));
    }

    /**
     * @param DfTable $table
     */
    public function checkUpdate($table)
    {
        $this->assertTrue($table->update(['email' => 'example1@example.com'], ['username' => 'daitel']));
    }
}
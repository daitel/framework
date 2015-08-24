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
        $this->checkSelect($table);
        $this->checkDelete($table);
    }

    /**
     * @param DfTable $table
     */
    private function checkInsert($table)
    {
        $this->assertTrue($table->insert(['username' => 'daitel', 'email' => 'example@example.com']));
        $this->assertTrue($table->insert([]));
    }

    /**
     * @param DfTable $table
     */
    private function checkUpdate($table)
    {
        $this->assertTrue($table->update(['email' => 'example1@example.com'], ['username' => 'daitel']));
    }

    /**
     * @param DfTable $table
     */
    private function checkSelect($table)
    {
        $this->assertEquals(
            'example1@example.com',
            $table->selectRecord('email', ['username' => 'daitel'])
        );

        $this->assertEquals(
            ['id' => 2, 'email' => 'example1@example.com'],
            $table->selectRecord(['id', 'email'], ['username' => 'daitel', 'email' => 'example1@example.com'])
        );

        $this->assertEquals(
            [['id' => 2, 'email' => 'example1@example.com']],
            $table->selectRecords(['id', 'email'], ['username' => 'daitel'])
        );
    }

    /**
     * @param DfTable $table
     */
    private function checkDelete($table)
    {
        $this->assertTrue($table->delete(['id' => 2]));
        $this->assertTrue($table->delete([], '', 'id <= 2'));
        $this->assertFalse($table->delete(['id' => 100]));
    }
}
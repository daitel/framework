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
        $this->assertTrue($table->insert(['username' => 'example123', 'email' => 'example12345@example.com']));
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

    /**
     * @depends testNewTable
     */
    public function testRecordSet()
    {
        $record = Users::record()->getByQuery("SELECT * FROM users WHERE id = :id", [':id' => 4]);
        $this->assertEquals('example123', $record->username);
        $this->assertEquals('example12345@example.com', $record->email);

        $record1 = Users::record()->getByQuery("SELECT * FROM users WHERE id = :id", [':id' => 4]);
        $this->assertEquals('example123', $record1->username);
        $this->assertEquals('example12345@example.com', $record1->email);

        $record2 = Users::record()->getRecord(['id' => 4]);
        $this->assertEquals('example123', $record2->username);
        $this->assertEquals('example12345@example.com', $record2->email);

        $record3 = Users::record()->getByPk(4);
        $this->assertEquals('example123', $record3->username);
        $this->assertEquals('example12345@example.com', $record3->email);

        foreach (Users::record()->getArrayByQuery("SELECT * FROM users WHERE id = :id", [':id' => 4]) as $qRecord) {
            $this->assertEquals('example123', $qRecord->username);
            $this->assertEquals('example12345@example.com', $qRecord->email);
        }

        $record4 = Users::record()->getByPk(3);
        $record4->username = 'test';
        $record4->save();

        $record5 = Users::record()->getByPk(3);
        $this->assertEquals('test', $record5->username);

        $record6 = Users::record()->create(['username' => 'test1', 'email' => 'test@example.com']);
        $record6->save();

        $record7 = Users::record()->getByQuery("SELECT * FROM users ORDER BY id DESC LIMIT 1");
        $this->assertEquals('test1', $record7->username);
    }
}
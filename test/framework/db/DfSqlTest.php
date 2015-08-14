<?php
/**
 * Daitel Framework
 * Test Class for sql query preparing
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 *
 */
class DfSqlTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test table name
     * @var string
     */
    private $table = 'test';

    /**
     * @covers DfSql::selectKey
     */
    public function testSelectKey()
    {
        $this->assertEquals("SELECT a FROM test", DfSql::selectKey($this->table, 'a'));
        $this->assertEquals(
            "SELECT a FROM test WHERE b = 'c'",
            DfSql::selectKey($this->table, 'a', ['b' => 'c'])
        );
        $this->assertEquals(
            "SELECT a FROM test WHERE b = 'c' AND d = 'e'",
            DfSql::selectKey($this->table, 'a', ['b' => 'c', 'd' => 'e'])
        );
        $this->assertEquals(
            "SELECT a FROM test WHERE b = 'c' OR d = 'e'",
            DfSql::selectKey($this->table, 'a', ['b' => 'c', 'd' => 'e'], 'OR')
        );
        $this->assertEquals(
            "SELECT a FROM test WHERE (b = 'c' OR d = 'e') AND f = 'g'",
            DfSql::selectKey($this->table, 'a', [], '', "WHERE (b = 'c' OR d = 'e') AND f = 'g'")
        );
        $this->assertEquals(
            "SELECT a FROM test WHERE (b = 'c' OR d = 'e') AND f = 'g'",
            DfSql::selectKey($this->table, 'a', [], '', "WHERE (b = 'c' OR d = 'e') AND f = 'g'")
        );
    }

    /**
     * @covers DfSql::selectKeys
     */
    public function testSelectKeys()
    {
        $this->assertEquals("SELECT a, b FROM test", DfSql::selectKeys($this->table, ['a', 'b']));
        $this->assertEquals(
            "SELECT a, b FROM test WHERE b = 'c'",
            DfSql::selectKeys($this->table, ['a', 'b'], ['b' => 'c'])
        );
    }

    /**
     * @covers DfSql::insert
     */
    public function testInsert()
    {
        $this->assertEquals("INSERT INTO test (a) VALUES('b')", DfSql::insert($this->table, ['a' => 'b']));
        $this->assertEquals(
            "INSERT INTO test (a, c) VALUES('b', 'd')",
            DfSql::insert($this->table, ['a' => 'b', 'c' => 'd'])
        );
    }

    /**
     * @covers DfSql::update
     */
    public function testUpdate()
    {
        $this->assertEquals(
            "UPDATE test SET a = 'b' WHERE c = 'd'",
            DfSql::update($this->table, ['a' => 'b'], ['c' => 'd'])
        );
        $this->assertEquals(
            "UPDATE test SET a = 'b' , c = 'd' WHERE e = 'f'",
            DfSql::update($this->table, ['a' => 'b', 'c' => 'd'], ['e' => 'f'])
        );
        $this->assertEquals(
            "UPDATE test SET a = 'b' WHERE c = 'd' AND e = 'f'",
            DfSql::update($this->table, ['a' => 'b'], ['c' => 'd', 'e' => 'f'])
        );
        $this->assertEquals(
            "UPDATE test SET a = 'b' WHERE c = 'd' OR e = 'f'",
            DfSql::update($this->table, ['a' => 'b'], ['c' => 'd', 'e' => 'f'], 'OR')
        );
        $this->assertEquals(
            "UPDATE test SET a = 'b' WHERE (c = 'd' OR e = 'f') AND g = 'h'",
            DfSql::update($this->table, ['a' => 'b'], '', '', "WHERE (c = 'd' OR e = 'f') AND g = 'h'")
        );
    }

    public function testSelectAll()
    {
        $this->assertEquals('SELECT * FROM test', DfSql::selectAll($this->table));
    }
}
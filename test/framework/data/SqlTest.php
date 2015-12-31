<?php
/**
 * @link https://github.com/daitel/framework
 */

use df\data\Sql;

/**
 * Test Class for sql query preparing
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 *
 */
class SqlTest extends PHPUnit_Framework_TestCase
{
    /**
     * Test table name
     * @var string
     */
    private $table = 'test';

    public function testSelectKey()
    {
        $this->assertEquals("SELECT a FROM test", Sql::selectKey($this->table, 'a'));
        $this->assertEquals(
            "SELECT a FROM test WHERE b = 'c'",
            Sql::selectKey($this->table, 'a', ['b' => 'c'])
        );
        $this->assertEquals(
            "SELECT a FROM test WHERE b = 'c' AND d = 'e'",
            Sql::selectKey($this->table, 'a', ['b' => 'c', 'd' => 'e'])
        );
        $this->assertEquals(
            "SELECT a FROM test WHERE b = 'c' OR d = 'e'",
            Sql::selectKey($this->table, 'a', ['b' => 'c', 'd' => 'e'], 'OR')
        );
        $this->assertEquals(
            "SELECT a FROM test WHERE (b = 'c' OR d = 'e') AND f = 'g'",
            Sql::selectKey($this->table, 'a', [], '', "WHERE (b = 'c' OR d = 'e') AND f = 'g'")
        );
        $this->assertEquals(
            "SELECT a FROM test WHERE (b = 'c' OR d = 'e') AND f = 'g'",
            Sql::selectKey($this->table, 'a', [], '', "WHERE (b = 'c' OR d = 'e') AND f = 'g'")
        );
    }

    public function testSelectKeys()
    {
        $this->assertEquals("SELECT a, b FROM test", Sql::selectKeys($this->table, ['a', 'b']));
        $this->assertEquals(
            "SELECT a, b FROM test WHERE b = 'c'",
            Sql::selectKeys($this->table, ['a', 'b'], ['b' => 'c'])
        );
    }

    public function testInsert()
    {
        $this->assertEquals("INSERT INTO test (a) VALUES('b')", Sql::insert($this->table, ['a' => 'b']));
        $this->assertEquals(
            "INSERT INTO test (a, c) VALUES('b', 'd')",
            Sql::insert($this->table, ['a' => 'b', 'c' => 'd'])
        );
    }

    public function testUpdate()
    {
        $this->assertEquals(
            "UPDATE test SET a = 'b' WHERE c = 'd'",
            Sql::update($this->table, ['a' => 'b'], ['c' => 'd'])
        );
        $this->assertEquals(
            "UPDATE test SET a = 'b' , c = 'd' WHERE e = 'f'",
            Sql::update($this->table, ['a' => 'b', 'c' => 'd'], ['e' => 'f'])
        );
        $this->assertEquals(
            "UPDATE test SET a = 'b' WHERE c = 'd' AND e = 'f'",
            Sql::update($this->table, ['a' => 'b'], ['c' => 'd', 'e' => 'f'])
        );
        $this->assertEquals(
            "UPDATE test SET a = 'b' WHERE c = 'd' OR e = 'f'",
            Sql::update($this->table, ['a' => 'b'], ['c' => 'd', 'e' => 'f'], 'OR')
        );
        $this->assertEquals(
            "UPDATE test SET a = 'b' WHERE (c = 'd' OR e = 'f') AND g = 'h'",
            Sql::update($this->table, ['a' => 'b'], '', '', "WHERE (c = 'd' OR e = 'f') AND g = 'h'")
        );
    }

    public function testSelectAll()
    {
        $this->assertEquals('SELECT * FROM test', Sql::selectAll($this->table));
    }

    public function testMakePlaceholders()
    {
        $this->assertEquals(
            [
                'keys' => 'username, email',
                'values' => '?, ?',
                'data' => ['example', 'example@example.com'],
                'array' => []
            ],
            Sql::makePlaceholders(['username' => 'example', 'email' => 'example@example.com'])
        );

        $this->assertEquals(
            [
                'keys' => 'username, email',
                'values' => ':username, :email',
                'data' => [':username' => 'example', ':email' => 'example@example.com'],
                'array' => ['username = :username', 'email = :email']
            ],
            Sql::makePlaceholders(['username' => 'example', 'email' => 'example@example.com'], false)
        );
    }
}
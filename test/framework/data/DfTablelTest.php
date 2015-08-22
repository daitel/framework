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
        $this->assertTrue(is_object($table = new DfTable($db, 'test')));

        $db->query(
            "CREATE TABLE `users` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `username` VARCHAR(50) NOT NULL,
                `email` VARCHAR(256) NOT NULL,
                PRIMARY KEY (`id`)
            )
            ENGINE=MyISAM;"
        );
        $db->query("TRUNCATE `users`");

        $this->assertEquals(1, $db->query("INSERT INTO users (username, email) VALUES(?, ?)", ['daitel', 'example@example.com'])->rowCount());
    }
}
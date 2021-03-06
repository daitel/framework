<?php
/**
 * Daitel Framework
 * Test Class for test db connection functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 * @since 0.2.1
 */
class DfDbConnectionTest extends PHPUnit_Framework_TestCase
{
    /**
     * @depends DfAppTest::testSetupEx
     */
    public function testConstruct()
    {
        $db = new DfDbConnection('mysql:host=localhost;dbname=test;charset=utf8', 'root', '');
        $this->assertTrue(is_object($db));

        $db->query(
            "CREATE TABLE IF NOT EXISTS `users` (
                `id` INT(11) NOT NULL AUTO_INCREMENT,
                `username` VARCHAR(50) NOT NULL,
                `email` VARCHAR(256) NOT NULL,
                PRIMARY KEY (`id`),
                UNIQUE INDEX `username` (`username`)
            )
            ENGINE=MyISAM;"
        );

        $db->query("TRUNCATE `users`");

        $db->query("INSERT INTO users (username, email) VALUES (?,?)", ['test', 'example.test@example.com']);
        $this->check($db);
    }

    /**
     * @param DfDbConnection $db
     */
    public function check($db)
    {
        $this->assertEquals(
            ['id' => 1, 'username' => 'test', 'email' => 'example.test@example.com'],
            $db->getRecordByQuery("SELECT * FROM users WHERE id = :id", [':id' => 1])
        );

        $this->assertEquals(
            [['id' => 1, 'username' => 'test', 'email' => 'example.test@example.com']],
            $db->getRecordsByQuery("SELECT * FROM users WHERE id = :id", [':id' => 1])
        );
    }

    /**
     * @expectedException DfSetupException
     */
    public function testIncorrectLink()
    {
        $db = new DfDbConnection('mysql:host=localhost;dbname=test1;charset=utf8', 'root', '');
    }
}
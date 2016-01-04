<?php
/**
 * @link https://github.com/daitel/framework
 */

use application\models\Users as Users;

/**
 * Test Class for test work with db active record
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.2.1
 */
class ActiveRecordTest extends PHPUnit_Framework_TestCase
{
    public function testgetName(){
        $this->assertEquals('users', Users::getName());
    }
}
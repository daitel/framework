<?php
/**
 * Daitel Framework
 * Mysql Worker Class
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 *
 */


class DfMysql extends DfComponent
{

    private $component_name = 'mysql';

    function __construct($config = array())
    {
        if (!mysql_connect($config['db_host'], $config['db_user'], $config['db_pass']) or !mysql_select_db($config['db_name'])) {
            DfComponent::addError('danger', $this->component_name, mysql_error());
        }
        mysql_query("SET NAMES 'utf8'");
        mysql_query("SET CHARACTER SET 'utf8'");
    }

    function query($query)
    {
        if ($res = mysql_query($query)) {
            return $res;
        } else {
            DfComponent::addError('danger', $this->component_name, mysql_error());
            return false;
        }

    }

}
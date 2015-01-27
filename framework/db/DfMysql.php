<?php
/**
 * DfMysql is logging class
 *
 * DfMysql class provide db functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.logging
 * @since 0.1.3
 */
class DfMysql extends DfComponent
{

    /**
     * @see DfComponent
     * @var string
     */
    private $component_name = 'mysql';

    /**
     * Constructor
     * @param array $config
     */
    public function __construct($config = array())
    {
        if (!mysql_connect($config['db_host'], $config['db_user'], $config['db_pass']) or !mysql_select_db(
                $config['db_name']
            )
        ) {
            $this->log('danger', $this->component_name, '', mysql_error());
        }
        mysql_query("SET NAMES 'utf8'");
        mysql_query("SET CHARACTER SET 'utf8'");
    }

    /**
     * Simple Query
     * @param $query
     * @return bool|resource
     */
    public function query($query)
    {
        if ($res = mysql_query($query)) {
            return $res;
        } else {
            $this->log('danger', $this->component_name, $query, mysql_error());
            return false;
        }

    }
}
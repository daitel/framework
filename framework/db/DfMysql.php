<?php
/**
 * DfMysql is db working class
 *
 * DfMysql class provide db functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.db
 * @since 0.0.0
 */
class DfMysql extends DfComponent
{
    /**
     * Affected or selected rows count
     * @var int
     */
    public $rows_count = 0;
    /**
     * @var bool
     */
    public $connect;
    /**
     * @var bool
     */
    private $connect_retry;
    /**
     * @see DfComponent
     * @var string
     */
    private $component_name = 'mysql';
    /**
     * Links to mysql server
     * @var array
     */
    private $links;
    /**
     * @var array
     */
    private $config;

    /**
     * Constructor
     * @param array $config
     */
    public function __construct($config = array())
    {
        $this->config = $config;
        $this->connect_retry = true;
        $this->connect = false;
    }

    /**
     * Insert Record
     * @param string $table
     * @param array $values
     * @return bool|resource
     */
    public function insert($table, $values)
    {
        return $this->query(DfSql::insert($table, $values));
    }

    /**
     * Simple Query
     * @param string $query
     * @param integer $link
     * @return resource
     */
    public function query($query, $link = 0)
    {
        if (!$link) {
            $link = $this->config['db_host'];
        }

        if (!$this->links[$link]) {
            $this->connect();
        }

        if ($this->connect) {
            $time = DfTimer_start();

            if ($res = mysql_query($query, $this->links[$link])) {
                $this->log($this->component_name, $query, '', 'info', 'log', DfTimer_stop($time));
                if (mysql_num_rows($res)) {
                    return $res;
                } else {
                    $this->rows_count = mysql_affected_rows();
                    if ($this->rows_count > 0) {
                        return $this->rows_count;
                    } else {
                        return false;
                    }
                }
            } else {
                $this->log(
                    $this->component_name,
                    $query,
                    mysql_error($this->links[$link]),
                    'warning',
                    'error',
                    DfTimer_stop($time)
                );
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Connect
     */
    private function connect()
    {
        if ($this->connect_retry) {
            if ($link = mysql_connect($this->config['db_host'], $this->config['db_user'], $this->config['db_pass'])) {
                $this->links[$this->config['db_host']] = $link;

                if (!mysql_select_db($this->config['db_name'], $this->links[$this->config['db_host']])) {
                    $this->connect = false;
                    $this->log($this->component_name, '', mysql_error(), 'danger');
                } else {
                    $this->connect = true;
                    $this->query("SET NAMES 'utf8'");
                    $this->query("SET CHARACTER SET 'utf8'");
                }
            } else {
                $this->connect = false;
                $this->log($this->component_name, '', mysql_error(), 'danger');
            }
            $this->connect_retry = false;
        }
    }

    /**
     * Update Query
     * @param string $table
     * @param array $values
     * @param array $where
     * @param string $type
     * @param string $other
     * @return bool|resource
     */
    public function update($table, $values, $where = [], $type = 'AND', $other = '')
    {
        return $this->query(DfSql::update($table, $values, $where, $type, $other));
    }

    /**
     * Get All Records
     * @param string $table
     * @return array|bool
     */
    public function getAll($table)
    {
        return $this->getRecordsFromQuery(DfSql::selectAll($table));
    }

    /**
     * Get Records from query
     * @param string $query
     * @return bool|array
     */
    public function getRecordsFromQuery($query)
    {
        $return = array();
        if ($res = $this->query($query)) {
            while ($row = mysql_fetch_array($res)) {
                $return[] = $row;
            }
            return $return;
        } else {
            return false;
        }
    }

    /**
     * Get Value by parameter
     * @param string $table
     * @param string $key
     * @param array $where
     * @param string $type
     * @param string $other
     * @return mixed
     */
    public function getValueByParam($table, $key, $where = [], $type = 'AND', $other = '')
    {
        return $this->getValueFromQuery(DfSql::selectKey($table, $key, $where, $type, $other), $key);
    }

    /**
     * Get Value from query
     * @param string $query
     * @param string $key
     * @return mixed
     */
    public function getValueFromQuery($query, $key)
    {
        $row = $this->getRecordFromQuery($query);
        return $row[$key];
    }

    /**
     * Get Record from query
     * @param $query
     * @return array|bool
     */
    public function getRecordFromQuery($query)
    {
        if ($row = $this->getRecordsFromQuery($query)) {
            return $row[0];
        } else {
            return false;
        }
    }

    /**
     * Get Values by parameter
     * @param string $table
     * @param string $key
     * @param array $where
     * @param string $type
     * @param string $other
     * @return mixed
     */
    public function getValuesByParam($table, $key, $where = [], $type = 'AND', $other = '')
    {
        return $this->getValuesByParam($table, DfSql::selectKey($table, $key, $where, $type, $other));
    }
}
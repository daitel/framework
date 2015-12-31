<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace df\data;

use df\base\Component;

/**
 * Table is class for work with db table
 *
 * Table class provide CRUD functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.data
 * @since 0.2.1
 */
class Table extends Component
{
    /**
     * Component Name
     * @var string
     */
    public $componentName = 'Table';
    /**
     * Table Name
     * @var string
     */
    public $table = '';
    /**
     * Db Connection
     * @var DbConnection
     */
    public $db;

    /**
     * Create table work class
     * @param DbConnection $db
     * @param string $name
     */
    public function __construct($db, $name)
    {
        $this->db = $db;
        $this->componentName .= ucwords($name);
        $this->table = $name;
    }

    /**
     * Insert Record in table
     * @param array $data
     * @return bool
     */
    public function insert($data)
    {
        $placeholders = Sql::makePlaceholders($data);
        $sqlKeys = $placeholders['keys'];
        $sqlValues = $placeholders['values'];
        $sqlData = $placeholders['data'];

        $sql = "INSERT INTO {$this->table} ({$sqlKeys}) VALUES ({$sqlValues})";

        return $this->db->queryWithRowOneCheck($sql, $sqlData);
    }

    /**
     * Delete Record
     * @param array $where
     * @param string $type
     * @param string $afterWhere
     * @return bool
     */
    public function delete($where = [], $type = 'AND', $afterWhere = '')
    {
        $sqlData = [];

        $sql = "DELETE FROM {$this->table}";

        if (!empty($where)) {
            $whereData = implode(" $type ", Sql::makePlaceholders($where, false)['array']);
            $sqlData = Sql::makePlaceholders($where, false)['data'];

            $sql .= " WHERE {$whereData}";
        }

        $sql .= (!empty($where) ? ' ' : ' WHERE ') . $afterWhere;

        return $this->db->queryWithRowOneCheck($sql, $sqlData);
    }

    /**
     * Select records
     * @param array|string $_key
     * @param array $where
     * @param string $type
     * @param string $beforeFrom
     * @param string $beforeWhere
     * @param string $afterWhere
     * @return array|mixed
     */
    public function selectRecords(
        $_key,
        $where = [],
        $type = 'AND',
        $beforeFrom = '',
        $beforeWhere = '',
        $afterWhere = ''
    ) {
        return $this->select(true, $_key, $where, $type, $beforeFrom, $beforeWhere, $afterWhere);
    }

    /**
     * Select request
     * @param bool $many
     * @param array|string $_key
     * @param array $where
     * @param string $type
     * @param string $beforeFrom
     * @param string $beforeWhere
     * @param string $afterWhere
     * @return array|mixed
     */
    private function select(
        $many,
        $_key,
        $where = [],
        $type = 'AND',
        $beforeFrom = '',
        $beforeWhere = '',
        $afterWhere = ''
    ) {
        $sqlData = [];

        $key = Sql::prepareKeys($_key);

        $sql = "SELECT {$key} {$beforeFrom} FROM {$this->table} {$beforeWhere}";

        if (!empty($where)) {
            $whereData = implode(" $type ", Sql::makePlaceholders($where, false)['array']);
            $sqlData = Sql::makePlaceholders($where, false)['data'];

            $sql .= " WHERE {$whereData}";
        }

        $sql .= (!empty($where) ? ' ' : ' WHERE ') . $afterWhere;

        return ($many === true ?
            $this->db->getRecordsByQuery($sql, $sqlData) :
            $this->db->getRecordByQuery($sql, $sqlData)
        );
    }

    /**
     * Select Record by keys and where
     * @param array|string $_key
     * @param array $where
     * @param string $type
     * @param string $beforeFrom
     * @param string $beforeWhere
     * @param string $afterWhere
     * @return array|mixed
     */
    public function selectRecord(
        $_key,
        $where = [],
        $type = 'AND',
        $beforeFrom = '',
        $beforeWhere = '',
        $afterWhere = ''
    ) {
        return (is_array($_key) || $_key == '*' ?
            $this->select(false, $_key, $where, $type, $beforeFrom, $beforeWhere, $afterWhere) :
            $this->select(false, $_key, $where, $type, $beforeFrom, $beforeWhere, $afterWhere)[$_key]
        );
    }

    /**
     * Update Request
     * @param array $set
     * @param array $where
     * @return bool
     */
    public function update($set, $where = [])
    {
        $setData = implode(', ', Sql::makePlaceholders($set, false)['array']);

        $sql = "UPDATE {$this->table} SET {$setData}";
        $sqlData = Sql::makePlaceholders($set, false)['data'];

        if (!empty($where)) {
            $whereData = implode(', ', Sql::makePlaceholders($where, false)['array']);
            $sqlData = array_merge($sqlData, Sql::makePlaceholders($where, false)['data']);

            $sql .= " WHERE {$whereData}";
        }

        return $this->db->queryWithRowOneCheck($sql, $sqlData);
    }
}
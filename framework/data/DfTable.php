<?php
/**
 * DfTable is class for work with db table
 *
 * DfTable class provide CRUD functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.data
 * @since 0.2.1
 */
class DfTable extends DfComponent
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
     * PDO Connection
     * @var DfDbConnection
     */
    protected $db;

    /**
     * Create table work class
     * @param DfDbConnection $db
     * @param string $name
     */
    public function __construct($db, $name)
    {
        $this->connection = $db;
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
        $placeholders = DfSql::makePlaceholders($data);
        $sqlKeys = $placeholders['keys'];
        $sqlValues = $placeholders['values'];
        $sqlData = $placeholders['data'];

        $sql = "INSERT INTO {$this->table} ({$sqlKeys}) VALUES ({$sqlValues})";

        return $this->queryWithRowOneCheck($sql, $sqlData);
    }

    /**
     * Make query and check rowCount equals 1
     * @param string $sql
     * @param array $sqlData
     * @return bool
     */
    private function queryWithRowOneCheck($sql, $sqlData = [])
    {
        $query = $this->connection->query($sql, $sqlData);

        if ($query === false) {
            return false;
        }

        return ($query->rowCount() == 1 ? true : false);
    }

    /**
     * Update Request
     * @param array $set
     * @param array $where
     * @return bool
     */
    public function update($set, $where = [])
    {
        $setData = implode(', ', DfSql::makePlaceholders($set, false)['array']);

        $sql = "UPDATE {$this->table} SET {$setData}";
        $sqlData = DfSql::makePlaceholders($set, false)['data'];

        if (!empty($where)) {
            $whereData = implode(', ', DfSql::makePlaceholders($where, false)['array']);
            $sqlData = array_merge($sqlData, DfSql::makePlaceholders($where, false)['data']);

            $sql .= " WHERE {$whereData}";
        }

        return $this->queryWithRowOneCheck($sql, $sqlData);
    }
}
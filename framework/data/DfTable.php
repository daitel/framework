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
    public $tableName = '';
    /**
     * PDO Connection
     * @var PDO
     */
    protected $connection;

    /**
     * Create table work class
     * @param DfDbConnection $db
     * @param string $name
     */
    public function __construct($db, $name)
    {
        $this->connection = $db;
        $this->componentName .= ucwords($name);
        $this->tableName = $name;
    }
}
<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace daitel\framework\data;

use DfApp;
use daitel\framework\utils\ClassHelper;

/**
 * ActiveRecord is data working class
 *
 * ActiveRecord created for work with 1 record from table
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.1.6
 */
abstract class ActiveRecord extends Record
{
    /**
     * Table
     * @var Table
     */
    protected static $table;
    /**
     * Table primary key
     * @var string
     */
    public $pk = 'id';

    /**
     * Get record by primary key
     * @param string|int $id
     * @return $this
     */
    public function getByPk($id)
    {
        $this->getRecord([$this->pk => $id]);
        return $this;
    }

    /**
     * Get record from Table and set to record
     * @param array $where
     * @param string $type
     * @param string $beforeFrom
     * @param string $beforeWhere
     * @param string $afterWhere
     * @return $this
     */
    public function getRecord($where = [], $type = 'AND', $beforeFrom = '', $beforeWhere = '', $afterWhere = '')
    {
        $this->setVariables(
            self::table()->selectRecord("*", $where, $type, $beforeFrom, $beforeWhere, $afterWhere)
        );
        return $this;
    }

    /**
     * Return instance of table for active record, if Table don't exist create instance and save
     * @return Table
     */
    private static function table()
    {
        if (self::$table === null) {
            self::$table = new Table(self::getDb(), self::getName());
        }

        return self::$table;
    }

    /**
     * Get instance of DbConnection
     * For customization can be overloading in called classes
     * @return DbConnection
     */
    public static function getDb()
    {
        return DfApp::app()->db;
    }

    /**
     * Get table name by class name
     * For customization can be overloading in called classes
     * @return string
     */
    public static function getName()
    {
        return strtolower(ClassHelper::getName(get_called_class()));
    }

    /**
     * Save record data
     */
    public function save()
    {
        if (isset($this->attributes[$this->pk])) {
            $this->update();
        } else {
            $this->insert();
        }
    }

    /**
     * Update record
     */
    protected function update()
    {
        self::table()->update($this->attributes, [$this->pk => $this->getPk()]);
    }

    /**
     * Get primary key value
     * @return string|int
     */
    public function getPk()
    {
        return $this->attributes[$this->pk];
    }

    protected function insert()
    {
        self::table()->insert($this->attributes);
    }

    /**
     * Get active record by query and data
     * @param $query
     * @param array $data
     * @return $this
     */
    public function getByQuery($query, $data = [])
    {
        $this->setVariables(self::table()->db->getRecordByQuery($query, $data));
        return $this;
    }

    /**
     * Get active record objects array by query and data
     * @param string $query
     * @param array $data
     * @return array
     */
    public function getArrayByQuery($query, $data = [])
    {
        $objects = [];

        foreach (self::table()->db->getRecordsByQuery($query, $data) as $object) {
            $objects[] = $this->record()->create($object);
        }

        return $objects;
    }

    /**
     * Set variables from array
     * @param array $data
     * @return $this
     */
    public function create($data = [])
    {
        $this->setVariables($data);
        return $this;
    }

    /**
     * Get instance of record via static
     * @param array $data
     * @return ActiveRecord
     */
    public static function record($data = [])
    {
        $class = get_called_class();
        return new $class($data);
    }
}
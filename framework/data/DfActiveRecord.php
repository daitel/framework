<?php
/**
 * DfActiveRecord is data working class
 *
 * DfActiveRecord created for work with 1 record from table
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.data
 * @since 0.1.6
 */
abstract class DfActiveRecord extends DfRecord
{
    /**
     * Table
     * @var DfTable
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
     * Get record from DfTable and set to record
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
            static::table()->selectRecord("*", $where, $type, $beforeFrom, $beforeWhere, $afterWhere)
        );
        return $this;
    }

    /**
     * Return instance of table for active record, if DfTable don't exist create instance and save
     * @return DfTable
     */
    private static function table()
    {
        if (static::$table === null) {
            static::$table = new DfTable(static::getDb(), static::getName());
        }

        return static::$table;
    }

    /**
     * Get instance of DfDbConnection
     * For customization can be overloading in called classes
     * @return DfDbConnection
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
        return strtolower(get_called_class());
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
        static::table()->update($this->attributes, [$this->pk => $this->getPk()]);
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
        static::table()->insert($this->attributes);
    }

    /**
     * Get active record by query and data
     * @param $query
     * @param array $data
     * @return $this
     */
    public function getByQuery($query, $data = [])
    {
        $this->setVariables(static::table()->db->getRecordByQuery($query, $data));
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

        foreach (static::table()->db->getRecordsByQuery($query, $data) as $object) {
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
     * @return DfActiveRecord
     */
    public static function record($data = [])
    {
        $class = get_called_class();
        return new $class($data);
    }
}
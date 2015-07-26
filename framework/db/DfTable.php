<?php
/**
 * DfTable is db working class
 * Created for work with table
 *
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.db
 * @since 0.1.7
 */
class DfTable
{
	/**
	 * DataBase
	 * @var DfMysql
	 */
	public $db;
	/**
	 * Table
	 * @var string
	 */
	public $table = '';
	/**
	 * Table Primary Key
	 * @var string
	 */
	public $primaryKey = 'id';
	/**
	 * @var string
	 */
	public $model;

	/**
	 * Construct
	 * @param DfMysql $db
	 * @param string $model
	 */
	public function __construct($db, $model)
	{
		$this->db = $db;
		$this->model = $model;
	}

	/**
	 * @param $id
	 * @return bool
	 */
	public function getByPk($id)
	{
		$id = mysql_real_escape_string($id);

		if ($this->primaryKey !== '') {
			$data = $this->db->getRecordByParam(
				$this->table,
				[
					[$this->primaryKey => $id]
				]
			);

			if (!empty($data)) {
				return new $this->model($data);
			} else {
				return false;
			}
		} else {
			return false;
		}
	}

	/**
	 * Save
	 * @param object $object
	 * @return bool
	 */
	public function save($object)
	{
		$id = $this->primaryKey;
		if (isset($object->$id)) {
			return ($this->update($id, $object) ? true : false);
		} else {
			return ($this->insert($object) ? true : false);
		}
	}

	/**
	 * Update
	 * @param string $pk
	 * @param object $object
	 * @return bool|resource
	 */
	protected function update($pk, $object)
	{
		$values = [];
		foreach ($object->attributes as $var) {
			if ($var !== $pk) {
				$values[] = [$var => $object->$var];
			}
		}

		return $this->db->update($this->table, $values, [[$pk => $object->$pk]]);
	}

	/**
	 * Insert
	 * @param object $object
	 * @return bool|resource
	 */
	public function insert($object)
	{
		$values = [];

		foreach ($object->attributes as $var) {
			if ($var !== 'id') {
				$values[$var] = $object->$var;
			}
		}

		return $this->db->insert($this->table, [$values]);
	}
}
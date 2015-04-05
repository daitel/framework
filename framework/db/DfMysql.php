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
	 * @param $query
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
	 * Simple Query
	 * @param string $query
	 * @return bool|resource
	 */
	public function query($query)
	{
		$this->log('site_debug', '', $query);
		if ($res = mysql_query($query)) {
			if (mysql_num_rows($res)) {
				return $res;
			} elseif ($this->rows_count = mysql_affected_rows() > 0) {
				return $this->rows_count;
			} else {
				return false;
			}
		} else {
			$this->log($this->component_name, $query, mysql_error());
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
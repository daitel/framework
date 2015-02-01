<?php
/**
 * DfSql is hepler class for preparing query
 *
 * DfMysql class provide db functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.db
 * @since 0.1.3
 */
class DfSql
{
	/**
	 * Create Query for select key
	 * @param string $table
	 * @param array $key
	 * @param array $where
	 * @param string $type
	 * @param string $other
	 * @return mixed
	 */
	public static function selectKey($table, $key, $where = [], $type = 'AND', $other = '')
	{
		return self::selectKeys($table, $key = [$key], $where = [], $type = 'AND', $other = '');
	}

	/**
	 * Create query for select keys
	 * @param string $table
	 * @param array $keys
	 * @param array $where
	 * @param string $type
	 * @param string $other
	 * @return string
	 */
	public static function selectKeys($table, $keys, $where = [], $type = 'AND', $other = '')
	{
		$query = "SELECT ";

		$i = 0;
		foreach ($keys as $key) {
			if ($i > 0) {
				$query .= ', ';
			}
			$query .= `$key`;
			$i++;
		}

		$query .= "FROM `$table`";

		if (!empty($where)) {
			$query .= ' WHERE ';
			$i = 0;
			if ($i > 0) {
				$query .= ' ' . $type;
			}
			foreach ($where as $key) {
				$query .= ' `' . $key[0] . "` = '" . $key[1] . "'";
				$i++;
			}
		}
		$query .= $other;

		return $query;
	}

	/**
	 * Select All
	 * @param string $table
	 * @return string
	 */
	public static function selectAll($table){
		return "SELECT * FROM `$table`";
	}
}

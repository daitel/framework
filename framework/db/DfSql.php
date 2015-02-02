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
	public static function selectKey($table, $key = [], $where = [], $type = 'AND', $other = '')
	{
		return self::selectKeys($table, [$key], $where, $type, $other);
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
		return "SELECT " .
		self::multiKey($keys) .
		" FROM " . self::writeKey($table) .
		(!empty($where) ? " WHERE" : '') . (!empty($where) ? ' ' . self::multiKeyWhere($where, $type) : '') .
		(!empty($other) ? " " . $other : '');
	}

	/**
	 * Multi key array parser
	 * @param array $keys
	 * @param string $type
	 * @return string
	 */
	public static function multiKey($keys, $type = 'key')
	{
		$query = '';
		$i = 0;

		foreach ($keys as $key) {
			if ($i > 0) {
				$query .= ', ';
			}
			if ($type == 'key') {
				$query .= self::writeKey($key);
			} else {
				$query .= "'" . $key . "'";
			}

			$i++;
		}

		return $query;
	}

	/**
	 * Add ' ` ' to key value
	 * @param string $key
	 * @return string
	 */
	public static function writeKey($key)
	{
		return '`' . $key . '`';
	}

	/**
	 * Keys array parsing, returning string
	 * @param array $keys
	 * @param string $type
	 * @return string
	 */
	public static function multiKeyWhere($keys = [], $type)
	{
		$query = '';

		if (!empty($keys)) {
			$i = 0;

			foreach ($keys as $QKey) {
				if ($i > 0) {
					$query .= ' ' . $type . ' ';
				}

				foreach ($QKey as $key => $value) {
					$query .= self::writeKey($key) . " = '" . $value . "'";
					$i++;
				}
			}
		}
		return $query;
	}

	/**
	 * Preparing Insert Query
	 * @param string $table
	 * @param array $values
	 * @return string
	 */
	public static function insert($table, $values)
	{

		$QKeys = [];
		$QValues = [];

		foreach ($values as $QValue) {
			foreach ($QValue as $key => $value) {
				$QKeys[] = $key;
				$QValues[] = $value;
			}
		}

		return "INSERT INTO " . self::writeKey($table) . " (" . self::multiKey($QKeys) . ") VALUES(" . self::multiKey(
			$QValues,
			'values'
		) . ")";
	}

	/**
	 * Select All
	 * @param string $table
	 * @return string
	 */
	public static function selectAll($table)
	{
		return "SELECT * FROM " . self::writeKey($table);
	}

	/**
	 * Update Request
	 * @param string $table
	 * @param array $values
	 * @param array $where
	 * @param string $type
	 * @param string $other
	 * @return string
	 */
	public static function update($table, $values, $where = [], $type = 'AND', $other = '')
	{
		return "UPDATE " . self::writeKey($table) .
		" SET ". self::multiKeyWhere($values, ',') .
		(!empty($where) ? " WHERE" : '') . (!empty($where) ? ' ' . self::multiKeyWhere($where, $type) : '') .
		(!empty($other) ? " " . $other : '');
	}
}

<?php
/**
 * DfSql is helper class for preparing query
 *
 * DfSql class provide sql query preparing functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.data
 * @since 0.1.3
 */
class DfSql
{
    /**
     * Make Placeholders
     * @param array $data
     * @param bool $unnamed
     * @return array
     */
    public static function makePlaceholders($data, $unnamed = true)
    {
        $keys = '';
        $placeholders = '';

        $sqlArray = [];
        $sqlData = [];

        if ($unnamed === true) {
            $placeholders = str_repeat("?, ", count($data));
        }

        foreach ($data as $key => $value) {
            if ($unnamed === true) {
                $sqlData[] = $value;
            } else {
                $placeholders .= ':' . $key . ', ';
                $sqlData[':' . $key] = $value;
                $sqlArray[] = "$key = :$key";
            }

            $keys .= "$key, ";
        }

        $placeholders = trim($placeholders, ", ");
        $keys = trim($keys, ", ");

        return ['keys' => $keys, 'values' => $placeholders, 'data' => $sqlData, 'array' => $sqlArray];
    }

    /**
     * Create Query for select key
     * @deprecated
     * @param string $table
     * @param string $key
     * @param array $where
     * @param string $type
     * @param string $other
     * @return string
     */
    public static function selectKey($table, $key, $where = [], $type = 'AND', $other = '')
    {
        return self::selectKeys($table, [$key], $where, $type, $other);
    }

    /**
     * Create query for select keys
     * @deprecated
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
        " FROM " . $table .
        (!empty($where) ? " WHERE" : '') . (!empty($where) ? ' ' . self::multiKeyWhere($where, $type) : '') .
        (!empty($other) ? " " . $other : '');
    }

    /**
     * Multi key array parser
     * @deprecated
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
                $query .= $key;
            } else {
                $query .= "'" . $key . "'";
            }

            $i++;
        }

        return $query;
    }

    /**
     * Keys array parsing, returning string
     * @deprecated
     * @param array $keys
     * @param string $type
     * @return string
     */
    public static function multiKeyWhere($keys = [], $type)
    {
        $query = '';

        if (!empty($keys)) {
            $i = 0;

            foreach ($keys as $key => $value) {
                if ($i > 0) {
                    $query .= ' ' . $type . ' ';
                }

                $query .= $key . " = '" . $value . "'";
                $i++;
            }
        }
        return $query;
    }

    /**
     * Make from array|string key string
     * @param array|string $_key
     * @param string $implode
     * @return string
     */
    public static function prepareKeys($_key, $implode = ', ')
    {
        if (is_array($_key)) {
            $key = implode($implode, $_key);
        } else {
            $key = $_key;
        }

        return $key;
    }

    /**
     * Preparing Insert Query
     * @deprecated
     * @param string $table
     * @param array $values
     * @return string
     */
    public static function insert($table, $values)
    {

        $QKeys = [];
        $QValues = [];

        foreach ($values as $key => $value) {
            $QKeys[] = $key;
            $QValues[] = $value;
        }

        return "INSERT INTO " . $table . " (" . self::multiKey($QKeys) . ") VALUES(" . self::multiKey(
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
        return "SELECT * FROM {$table}";
    }

    /**
     * Update Request
     * @deprecated
     * @param string $table
     * @param array $values
     * @param array $where
     * @param string $type
     * @param string $other
     * @return string
     */
    public static function update($table, $values, $where = [], $type = 'AND', $other = '')
    {
        return "UPDATE " . $table .
        " SET " . self::multiKeyWhere($values, ',') .
        (!empty($where) ? " WHERE" : '') . (!empty($where) ? ' ' . self::multiKeyWhere($where, $type) : '') .
        (!empty($other) ? " " . $other : '');
    }

    /**
     * Return string with current datetime as mysql format
     * Format: Y-m-d H:i:s
     * @return string
     */
    public static function datetime()
    {
        return date("Y-m-d H:i:s");
    }

    /**
     * Return string with current date as mysql format
     * Format: Y-m-d
     * @return string
     */
    public static function date()
    {
        return date("Y-m-d");
    }

    /**
     * Return string with current time as mysql format
     * Format: Y-m-d H:i:s
     * @return string
     */
    public static function time()
    {
        return date("H:i:s");
    }
}
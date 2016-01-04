<?php
/**
 * @link https://github.com/daitel/framework
 */
namespace daitel\framework\data;

use daitel\framework\base\Component;
use daitel\framework\base\Exception;
use daitel\framework\base\SetupException;

use PDO;
use PDOStatement;
use PDOException;

/**
 * DbConnection is data connection class
 *
 * DbConnection class provide db connection functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @since 0.2.1
 */
class DbConnection extends Component
{
    /**
     * Component Name
     * @var string
     */
    public $componentName = 'DbConnection';
    /**
     * PDO Connection
     * @var PDO
     */
    protected $connection;
    /**
     * Connection link
     * @var string
     */
    protected $link = '';
    /**
     * Connection user
     * @var string
     */
    protected $user = '';
    /**
     * Connection pass
     * @var string
     */
    protected $pass = '';
    /**
     * Connections options
     * @var array
     */
    protected $options = [];

    /**
     * Create PDO connection
     * @throws SetupException
     */
    public function afterConstruct()
    {
        try {
            $this->connection = new PDO($this->link, $this->user, $this->pass, $this->options);
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $ex) {
            throw new SetupException($ex->getMessage(), 0, $ex->getFile(), $ex->getLine(), $ex);
        }
    }

    /**
     * Query
     * @param string $sql
     * @param array $data
     * @return PDOStatement
     */
    public function query($sql, $data = [])
    {
        try {
            if (!empty($data)) {
                $query = $this->connection->prepare($sql);
                $query->execute($data);
            } else {
                $query = $this->connection->query($sql);
            }
            return $query;
        } catch (Exception $ex) {
            $this->log($ex->getMessage(), $sql . '|' . serialize($data));
            return false;
        }
    }

    /**
     * Get records by sql query
     * @param string $sql
     * @param array $data
     * @return array|mixed
     */
    public function getRecordsByQuery($sql, $data = [])
    {
        return $this->fetchByQuery($sql, $data, true);
    }

    /**
     * Make query and check rowCount equals 1
     * @param string $sql
     * @param array $sqlData
     * @return bool
     */
    public function queryWithRowOneCheck($sql, $sqlData = [])
    {
        $query = $this->query($sql, $sqlData);

        if ($query === false) {
            return false;
        }

        return ($query->rowCount() == 1 ? true : false);
    }

    /**
     * Get record by sql query
     * @param string $sql
     * @param array $data
     * @return array|mixed
     */
    public function getRecordByQuery($sql, $data = [])
    {
        return $this->fetchByQuery($sql, $data);
    }

    /**
     * Make PDO query and fetch result
     * @param string $sql
     * @param array $data
     * @param bool $all
     * @return array|mixed
     */
    private function fetchByQuery($sql, $data = [], $all = false)
    {
        $query = $this->query($sql, $data);
        return ($all == true ? $query->fetchAll(PDO::FETCH_NAMED) : $query->fetch(PDO::FETCH_NAMED));
    }
}
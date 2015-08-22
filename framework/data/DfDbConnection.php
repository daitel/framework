<?php
/**
 * DfDbConnection is data connection class
 *
 * DfMysql class provide connection functions
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.data
 * @since 0.2.1
 */
class DfDbConnection extends DfComponent
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
     * __construct
     * @param string $link
     * @param string $user
     * @param string $pass
     * @param array $options
     */
    public function __construct($link, $user, $pass, $options = [])
    {
        $this->connect($link, $user, $pass, $options);
    }

    /**
     * Create PDO connection
     * @param string $link
     * @param string $user
     * @param string $pass
     * @param array $options
     * @throws DfSetupException
     */
    private function connect($link, $user, $pass, $options)
    {
        try {
            $this->connection = new PDO($link, $user, $pass, $options);
        } catch (PDOException $ex) {
            throw new DfSetupException($ex->getMessage(), 0, $ex->getFile(), $ex->getLine(), $ex);
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
        if (!empty($data)) {
            $query = $this->connection->prepare($sql);
            $query->execute($data);
        } else {
            $query = $this->connection->query($sql);
        }
        return $query;
    }
}
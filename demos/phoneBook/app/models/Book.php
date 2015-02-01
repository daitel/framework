<?php
/**
 * Daitel Framework
 * Phone Book model
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @link https://github.com/daitel/framework
 */
class Book
{
	/**
	 * @var DfMysql
	 */
	public $db;
	/**
	 * Table Name
	 * @var string
	 */
	private $tableName = 'book';

	/**
	 * Constructor
	 * @param array $config
	 */
	public function __construct($config = array())
	{
		$this->db = new DfMysql($config);
	}

	/**
	 * Get Book
	 * @return array|bool
	 */
	public function getBook()
	{
		return $this->db->getAll($this->tableName);
	}
}
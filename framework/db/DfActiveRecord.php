<?php
/**
 * DfActiveRecord is db working class
 * Created for work with 1 record from table
 *
 *
 * @author Nikita Fedoseev <agent.daitel@gmail.com>
 * @package system.db
 * @since 0.1.6
 */
class DfActiveRecord
{
	/**
	 * @var array
	 */
	public $attributes = [];

	/**
	 * Construct
	 * @param array $data
	 */
	public function __construct($data = [])
	{
		if (!empty($data)) {
			$this->setVariables();
		}
	}

	/**
	 * Set Variables
	 * @param array $data
	 */
	private function setVariables($data = [])
	{
		foreach ($data as $name_var => $var) {
			if (!is_int($name_var)) {
				$this->$name_var = $var;
				$this->attributes[] = $name_var;
			}
		}
	}
}
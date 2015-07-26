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
	 * Attributes
	 * @var array
	 */
	public $attributes = [];
	/**
	 * Data Array
	 * @var array
	 */
	protected $data = [];

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
	protected function setVariables($data = [])
	{
		if(!empty($data)){
			foreach ($data as $name_var => $var) {
				$this->setVariable($name_var, $var);
			}
		}
	}

	/**
	 * Set Variable
	 * @param $name_var
	 * @param $var
	 */
	private function setVariable($name_var, $var)
	{
		$this->data[$name_var] = $var;
		$this->attributes[] = $name_var;
	}

	/**
	 * Get magic method
	 * @param $name
	 * @return bool
	 */
	public function __get($name)
	{
		if (isset($this->data[$name])) {
			return $this->data[$name];
		} else {
			return false;
		}
	}

	/**
	 * Set magic method
	 * @param $name
	 * @param $val
	 */
	public function __set($name, $val)
	{
		$this->setVariable($name, $val);
	}
}
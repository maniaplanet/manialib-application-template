<?php

class ManiaLib_Database_RecordSet
{
	const FETCH_ASSOC = MYSQL_ASSOC;
	const FETCH_NUM = MYSQL_NUM;
	const FETCH_BOTH = MYSQL_BOTH;

	protected $result;

	function __construct($result)
	{
		$this->result = $result;
	}
	
	/**
	 * Get a result row as an enumerated array
	 * @return array
	 */
	function fetchRow()
	{
		return mysql_fetch_row($this->result);
	}
	
	/**
	 * Fetch a result row as an associative array
	 * @return array
	 */
	function fetchAssoc()
	{
		return mysql_fetch_assoc($this->result);
	}
	
	/**
	 * Fetch a result row as an associative, a numeric array, or both
	 * @return array
	 */	
	function fetchArray($resultType = self::FETCH_ASSOC)
	{
		return mysql_fetch_array($this->result, $resultType);
	}
	
	/**
	 * Returns the current row of a result set as an object
	 * @param string The name of the class to instantiate, set the properties of and return. If not specified, a stdClass object is returned.
	 * @param array An optional array of parameters to pass to the constructor for class_name objects.
	 * @return object
	 */	
	function fetchObject($className, array $params = array())
	{
		if($className)
		{
			if($params)
			{
				return mysql_fetch_object($this->result, $className, $params);
			}
			else
			{
				return mysql_fetch_object($this->result, $className);
			}
		}	
		else
		{
			return mysql_fetch_object($this->result);
		}
	}
	
	/**
	 * Gets the number of rows in a result
	 * @return int
	 */
	function recordCount()
	{
		return mysql_num_rows($this->result);
	}
}

?>
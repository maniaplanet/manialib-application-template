<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\Database;

/**
 * Database result
 */
class RecordSet
{
	const FETCH_ASSOC = MYSQL_ASSOC;
	const FETCH_NUM = MYSQL_NUM;
	const FETCH_BOTH = MYSQL_BOTH;

	protected $result;

	function __construct($result)
	{
		$this->result = $result;
	}
	
	function checkIfEmpty()
	{
		if($this->recordCount() == 0)
		{
			throw new \ManiaLib\Services\NotFoundException();
		}
	}
	
	/**
	 * Get a result row as an enumerated array
	 * @return array
	 */
	function fetchRow()
	{
		return mysql_fetch_row($this->result);
	}
	
	function fetchArrayOfRow()
	{
		$array = array();
		while($row = $this->fetchRow())
		{
			$array[] = $row;
		}
		return $array;
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
	 * @param string The name of the class to instantiate, set the properties of and return. If not specified, a \stdClass object is returned.
	 * @param array An optional array of parameters to pass to the constructor for class_name objects.
	 * @return object
	 */	
	function fetchObject($className='\\stdClass', $params = array())
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
	 * Fetches a single value of the current row, or the default value if there's no row.
	 * Typically useful for SELECT COUNT() queries.
	 */
	function fetchSingleValue($default = 0, $throwException = false)
	{
		if($row = $this->fetchRow())
		{
			return reset($row);
		}
		elseif(!$throwException)
		{
			return $default;
		}
		else
		{
			throw new \ManiaLib\Services\NotFoundException();
		}
	}
	
	function fetchArrayOfSingleValues()
	{
		$array = array();
		while($row = mysql_fetch_row($this->result))
		{
			$array[] = reset($row);
		}
		return $array;
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
<?php
/**
 * @package Manialib
 * @author Maxime Raoust
 */

// TODO DatabaseEngine refactoring

/**
 * Protects a string to be used in a database query
 * 
 * @param String $value;
 * @param Bool $gpc=true
 * @return String
 */
function quote_smart($value, $gpc = true)
{
	// Stripslashes
	if ($gpc && get_magic_quotes_gpc())
	{
		$value = stripslashes($value);
	}
	$value = '\'' . mysql_real_escape_string($value) . '\'';
	return $value;
}

/**
 * Protects a string to be used in a database query
 * 
 * @param String &$value;
 * @param Bool $gpc=true
 */
function quote_smart_ref(& $value, $gpc = true)
{
	// Stripslashes
	if ($gpc && get_magic_quotes_gpc())
	{
		$value = stripslashes($value);
	}
	$value = '\'' . mysql_real_escape_string($value) . '\'';
}

/**
 * Simple Mysql abstraction class
 */
final class DatabaseEngine
{
	protected static $instance;
	protected $connection;
	protected $result;
	public $query;
	
	/**
	 * Gets the instance
	 */
	public static function getInstance()
	{
		if (!self::$instance)
		{
			$class = __CLASS__;
			self::$instance = new $class ();
		}
		return self::$instance;
	}

	protected function __construct()
	{
		
		$this->connection = mysql_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD);
		

		if ($this->connection === false)
		{
			throw new DatabaseException;
		}

		if (function_exists('mysql_set_charset'))
		{
			mysql_set_charset('utf8');
		} else
		{
			$this->query = 'SET NAMES \'utf8\'';
			$this->query();
		}

		if (mysql_select_connection(DATABASE_NAME, $this->connection) === false)
		{
			throw new DatabaseException;
		}
	}

	/**
	 * Executes the database query stored in self::$query. Store the result in
	 * self::rs. Behavior can be changed with both params. Throws an exception
	 * on error.
	 * @param string
	 * @param boolean
	 * @return ressource Mysql result
	 */
	function query($query = null, $saveResult = true)
	{
		$_query = $query ? $query : $this->query;
		$result = mysql_query($_query, $this->connection);
		
		if ($result == false)
		{
			throw new DatabaseException($_query);
		}
		if ($saveResult)
		{
			$this->result = $result;
		}
		return $result;
	}

	/**
	 * Counts the rows in the last result set
	 * @return int
	 */
	function numRows()
	{
		return mysql_num_rows($this->result);
	}

	/**
	 * Counts the affected rows of the last query
	 * @return int
	 */
	function affectedRows()
	{
		return mysql_affected_rows($this->connection);
	}

	/**
	 * Fetches the last result into an array
	 * @param int Mysql result type (MYSQL_FETCH_ASSOC, MYSQL_FETCH_NUM,
	 * MYSQL_FETCH_BOTH)
	 * @return Array
	 */
	function fetchArray($resultType = MYSQL_FETCH_ASSOC)
	{
		if ($this->result)
			return mysql_fetch_array($this->result, $resultType);
		else
			return false;
	}
	
	/**
	 * Fetches the current row
	 * @return array
	 */
	function fetchRow()
	{
		if ($this->result)
			return mysql_fetch_row($this->result);
		else
			return false;
	}

	/**
	 * Returns the last inserted ID
	 * @return int
	 */
	function insertId()
	{
		return mysql_insert_id($this->connection);
	}
}

class DatabaseException extends ManialinkException
{
	protected $query;
	function __construct($query='')
	{
		parent::__construct(mysql_error(), mysql_errno());
		$this->query = $query;
	}
}
?>
<?php
/**
 * Database abstraction
 * 
 * @author Maxime Raoust
 */

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
	$value = "'" . mysql_real_escape_string($value) . "'";
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
	$value = "'" . mysql_real_escape_string($value) . "'";
}

final class DatabaseEngine
{
	private static $instance;
	private $db;
	private $rs;
	public $query;
	
	/**
	 * Get the instance
	 */
	public static function getInstance()
	{
		if (!self :: $instance)
		{
			$class = __CLASS__;
			self :: $instance = new $class ();
		}
		return self :: $instance;
	}

	/** 
	 * Constructor
	 */
	private function __construct()
	{
		
		$this->db = mysql_connect(DATABASE_HOST, DATABASE_USER, DATABASE_PASSWORD);
		

		if ($this->db === false)
		{
			trigger_error("Database connection error");
		}

		if (function_exists("mysql_set_charset"))
		{
			mysql_set_charset("utf8");
		} else
		{
			$this->query = "SET NAMES 'utf8'";
			$this->query();
		}

		if (mysql_select_db(DATABASE_NAME, $this->db) === false)
		{
			trigger_error("Database selection error");
		}
	}

	/**
	 * Execute the database query stored in $this->query. Store the result in
	 * $this->rs. Returns false on error. Behavior can be changed with both 
	 * params
	 * 
	 * @param String $query=null
	 * @param Bool $onlyReturnResult=false
	 * @return AdodbRecordSet (or false)
	 */
	function query($query = null, $saveResult = true)
	{
		if ($query == null)
			$_query = $this->query;
		else
			$_query = $query;

		$rs = mysql_query($_query, $this->db);

		if ($saveResult)
		{
			$this->rs = $rs;
		}
		if ($rs == false)
		{
			trigger_error("Database query error : " . mysql_error() . ", query= $_query");
			return false;
		} else
		{
			return $rs;
		}
	}

	/**
	 * Count the rows the last result
	 * 
	 * @return Int
	 */
	function numRows()
	{
		return mysql_num_rows($this->rs);
	}

	/**
	 * Count the affected rows of the last query
	 * 
	 * @return Int
	 */
	function affectedRows()
	{
		return mysql_affected_rows($this->db);
	}

	/**
	 * Fetch the last result into an array
	 * 
	 * @return Array
	 */
	function fetchArray()
	{
		if ($this->rs)
			return mysql_fetch_array($this->rs);
		else
			return false;
	}
	
	/**
	 * Fetch the current row
	 * 
	 * @return Array
	 */
	function fetchRow()
	{
		if ($this->rs)
			return mysql_fetch_row($this->rs);
		else
			return false;
	}

	/**
	 * Return the last inserted ID
	 * 
	 * @return Int
	 */
	function insertId()
	{
		return mysql_insert_id($this->db);
	}
}
?>
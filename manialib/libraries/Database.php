<?php
/**
 * MySQL abstraction layer, based on PHP's MySQLi extension
 * 
 * Usage example:
 * <code>
 * <?php
 * 
 * require_once(APP_FRAMEWORK_LIBRARIES_PATH.'Database.php');
 * 
 * try
 * {
 *     $database = DatabaseConnection::getInstance();
 *     $result = $database->execute('SELECT * FROM mytable WHERE id < 10');
 *     while($array = $result->fetchAssoc())
 *     {
 *         print_r($array);
 *     }
 *     $myvar = 'Some \'text with quotes\' and "double quotes"';
 *     $myvarQuoted = $database->quote($myvar);
 *     $database->execute( 'INSERT INTO mytable (MyText) VALUES ('.$myvarQuoted.')' );
 *     echo $database->insertID.' is a newly inserted ID';
 * }
 * catch(Exception $e)
 * {
 *     // Error handling...
 * }
 * ?>
 * </code>
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * Database connection instance
 * @package ManiaLib
 * @subpackage Database
 */
class DatabaseConnection
{
	/**
	 * @ignore
	 */
	static protected $instance;
	/**#@+
	 * @ignore
	 */
	protected $connection;
	protected $host;
	protected $user;
	protected $password;
	protected $database;
	protected $charset;
	/**#@-*/
	
	/**
	 * Get an instance on the database connection object, and connects to the mysql server if needed
	 * To configure your connection, override these constants in your config:
	 * <ul>
	 * <li>APP_DATABASE_HOST</li>
	 * <li>APP_DATABASE_USER</li>
	 * <li>APP_DATABASE_PASSWORD</li>
	 * <li>APP_DATABASE_NAME</li>
	 * <li>APP_DATABASE_CHARSET</li>
	 * </ul>
	 * 
	 * @return DatabaseConnection
	 */
	public static function getInstance()
	{
		if (!self::$instance)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}
	
	/**
	 * @throws DatabaseConnectionException
	 * @ignore
	 */
	protected function __construct()
	{
		$this->host = APP_DATABASE_HOST;
		$this->user = APP_DATABASE_USER;
		$this->password = APP_DATABASE_PASSWORD;
		
		$this->connection = mysql_connect($this->host, $this->user, $this->password);
				
		if(!$this->connection)
		{
			throw new DatabaseConnectionException();
		}

		$this->select(APP_DATABASE_NAME);	
		$this->setCharset(APP_DATABASE_CHARSET);
	}
	
	/**
	 * Sets the charset for the database connection
	 */
	function setCharset($charset)
	{
		if($charset != $this->charset)
		{
			$this->charset = $charset;
			if(!mysql_set_charset($charset, $this->connection))
			{
				throw new DatabaseException('Couldn\'t set charset: '.$charset);
			}
		}
	}
	
	/**
	 * Selects a database
	 */
	function select($database)
	{
		if($database != $this->database)
		{
			$this->database = $database;
			if(!mysql_select_db($this->database, $this->connection))
			{
				throw new DatabaseSelectionException(mysql_error(), mysql_errno());
			}
		}
	}

	/**
	 * Escape and quote variables so you can insert them safely
	 */
	function quote($string)
	{
		return '\''.mysql_real_escape_string($string, $this->connection).'\'';
	}
	
	/**
	 * Executes a query
	 * @param string The query
	 * @return DatabaseRecordSet
	 */
	function execute($query)
	{
		$result = mysql_query($query, $this->connection);
		if(!$result)
		{
			throw new DatabaseQueryException(mysql_error(), mysql_errno());
		}
		return new DatabaseRecordSet($result);
	}
	
	/**
	 * Get number of affected rows in previous operation
	 * @return int
	 */
	function affectedRows()
	{
		return mysql_affected_rows($this->connection);
	}
	
	/**
	 * Get the ID generated in the last query
	 * @return int
	 */
	function insertID()
	{
		return mysql_insert_id($this->connection);
	}
	
	/**
	 * @return bool 
	 */
	function isConnected()
	{
		return (!$this->connection); 
	}

	/**
	 * Currently selected database
	 * @return string
	 */
	function getDatabase()
	{
		return $this->database;
	}
}

/**
 * Database query result
 * @package ManiaLib
 * @subpackage Database
 */
class DatabaseRecordSet
{
	/**#@+
	 * Constants to use with DatabaseRecordSet::fetchArray()
	 */
	const FETCH_ASSOC = MYSQL_ASSOC;
	const FETCH_NUM = MYSQL_NUM;
	const FETCH_BOTH = MYSQL_BOTH;
	/**#@-*/

	/**
	 * MySQL ressource
	 * @ignore
	 */
	protected $result;
	
	/**
	 * @ignore
	 */
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
			return mysql_fetch_object($this->result, $className, $params);
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

/**
 * Misc database tools
 * @package ManiaLib
 * @subpackage Database
 */
abstract class DatabaseTools
{
	/**
	 * Returns the "LIMIT x,x" string depending on both values
	 */
	static function getLimitString($offset, $length)
	{
		if(!$offset && !$length)
		{
			return '';
		}
		elseif(!$offset && $length==1)
		{
			return 'LIMIT 1';
		}
		else
		{
			return 'LIMIT '.$offset.', '.$length;
		}
	}
	
	/**
	 * Returns string like "(name1, name2) VALUES (value1, value2)" 
	 */
	static function getValuesString(array $values)
	{
		return 
			'('.implode(', ', array_keys($values)).') '.
			'VALUES '.
			'('.implode(', ', $values).')';
	}
	
	/**
	 * Returns string like "name1=VALUES(name1), name2=VALUES(name2)"
	 */
	static function getOnDuplicateKeyUpdateValuesString(array $valueNames)
	{
		$strings = array(); 
		foreach($valueNames as $valueName)
		{
			$strings[] = $valueName.'=VALUES('.$valueName.')';
		}
		return implode(', ', $strings);
	}
}

/**
 * @package ManiaLib
 * @subpackage Database
 * @ignore
 */
class DatabaseException extends Exception {}

/**
 * @package ManiaLib
 * @subpackage Database
 * @ignore
 */
class DatabaseConnectionException extends DatabaseException {}

/**
 * @package ManiaLib
 * @subpackage Database
 * @ignore
 */
class DatabaseSelectionException extends DatabaseException {}

/**
 * @package ManiaLib
 * @subpackage Database
 * @ignore
 */
class DatabaseQueryException extends DatabaseException {}

?>

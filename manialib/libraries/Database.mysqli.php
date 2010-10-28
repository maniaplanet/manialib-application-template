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
 * Database connection
 * @package ManiaLib
 * @subpackage Database
 */
class DatabaseConnection
{
	/**
	 * @ignore
	 */
	static protected $instance;
	/**
	 * @var mysqli
	 * @ignore
	 */
	/**#@+
	 * @ignore
	 */
	protected $connection;
	protected $host;
	protected $user;
	protected $password;
	protected $database;
	/**#@-*/
	
	/**
	 * @return DatabaseConnection
	 */
	public static function getInstance(
		$host = APP_DATABASE_HOST, 
		$user = APP_DATABASE_USER, 
		$password = APP_DATABASE_PASSWORD, 
		$database = APP_DATABASE_NAME, 
		$useSSL = false, 
		$forceNewConnection = false)
	{
		if (!self::$instance)
		{
			$class = __CLASS__;
			self::$instance = new $class($host, $user, $password, $database);
		}
		return self::$instance;
	}
	
	/**
	 * @ignore
	 */
	protected function __construct($host, $user, $password, $database)
	{
		// Init
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->database = $database;
		
		// Connection
		$this->connection = new mysqli(
			$this->host,
			$this->user,
			$this->password,
			$this->database
		);
				
		// Success ?
		if($this->connection->connect_error)
		{
			throw new DatabaseException($this->connection->connect_error, 
				$this->connection->connect_errno);
		}
		
		// Default Charset : UTF8
		$this->setCharset('utf8');
	}
	
	/**
	 * @ignore
	 */
	function __destruct()
	{
		$this->connection->close();
	}
	
	/**
	 * Sets the charset for the database connection
	 */
	function setCharset($charset)
	{
		if(!$this->connection->set_charset($charset))
		{
			throw new DatabaseException($this->connection->error, $this->connection->errno);
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
			if(!$this->connection->select_db($this->database))
			{
				throw new DatabaseException($this->connection->error, $this->connection->errno);
			}
		}
	}
	
	/**
	 * Escape and quote variables so you can insert them safely
	 */
	function quote($string)
	{
		return '\''.$this->connection->escape_string($string).'\'';
	}
	
	/**
	 * Executes a query
	 * @param string The query
	 * @return DatabaseRecordSet
	 */
	function execute($query)
	{
		$result = $this->connection->query($query);
		if(!$result)
		{
			throw new DatabaseQueryException($this->connection->error, $this->connection->errno);
		}
		return new DatabaseRecordSet($result);
	}
	
	/**
	 * Get number of affected rows in previous operation
	 * @return int
	 */
	function affectedRows()
	{
		return $this->connection->affected_rows;
	}
	
	/**
	 * Get the ID generated in the last query
	 * @return int
	 */
	function insertID()
	{
		return $this->connection->insert_id;
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
 * Database result
 * @package ManiaLib
 * @subpackage Database
 */
class DatabaseRecordSet
{
	const FETCH_ASSOC = MYSQLI_ASSOC;
	const FETCH_NUM = MYSQLI_NUM;
	const FETCH_BOTH = MYSQLI_BOTH;

	/**
	 * @var MySQLi_RESULT
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
	 * @ignore
	 */
	function __destruct()
	{
		if($this->result instanceof MySQLi_RESULT)
		{
			$this->result->close();
		}
	}
	
	/**
	 * Get a result row as an enumerated array
	 * @return array
	 */
	function fetchRow()
	{
		return $this->result->fetch_row();
	}
	
	/**
	 * Fetch a result row as an associative array
	 * @return array
	 */
	function fetchAssoc()
	{
		return $this->result->fetch_assoc();
	}
	
	/**
	 * Fetch a result row as an associative, a numeric array, or both
	 * @return array
	 */
	function fetchArray($resultType = self::FETCH_ASSOC)
	{
		return $this->result->fetch_array($resultType);
	}
	
	/**
	 * Returns the current row of a result set as an object
	 * @param string The name of the class to instantiate, set the properties of and return. If not specified, a stdClass object is returned.
	 * @param array An optional array of parameters to pass to the constructor for class_name objects.
	 * @return object
	 */
	function fetchObject($className, array $params=array() )
	{
		if($className)
		{
			return $this->result->fetch_object($className, $params);
		}	
		else
		{
			return $this->fetchObject();
		}	
	}
	
	/**
	 * Gets the number of rows in a result
	 * @return int
	 */
	function recordCount()
	{
		return $this->result->num_rows;
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
	 * @return string
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
	 * @return string 
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
	 * @return string
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
class DatabaseException extends FrameworkException {}

/**
 * @package ManiaLib
 * @subpackage Database
 * @ignore
 */
class DatabaseQueryException extends DatabaseException {}

?>
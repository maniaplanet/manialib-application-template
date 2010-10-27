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
	static protected $instance;
	/**
	 * @var mysqli
	 */
	protected $connection;
	protected $host;
	protected $user;
	protected $password;
	protected $database;
	
	/**
	 * 
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
	
	function __destruct()
	{
		$this->connection->close();
	}
	
	function setCharset($charset)
	{
		if(!$this->connection->set_charset($charset))
		{
			throw new DatabaseException($this->connection->error, $this->connection->errno);
		}
	}
	
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
		
	function quote($string)
	{
		return '\''.$this->connection->escape_string($string).'\'';
	}
	
	/**
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
	
	function affectedRows()
	{
		return $this->connection->affected_rows;
	}
	
	function insertID()
	{
		return $this->connection->insert_id;
	}
	
	function isConnected()
	{
		return (!$this->connection); 
	}
		
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
	const FETCH_ASSOC = MYSQLI_ASSOC;
	const FETCH_NUM = MYSQLI_NUM;
	const FETCH_BOTH = MYSQLI_BOTH;

	/**
	 * @var MySQLi_RESULT
	 */
	protected $result;
	
	function __construct($result)
	{
		$this->result = $result;
	}
	
	function __destruct()
	{
		if($this->result instanceof MySQLi_RESULT)
		{
			$this->result->close();
		}
	}
	
	function fetchRow()
	{
		return $this->result->fetch_row();
	}
	
	function fetchAssoc()
	{
		return $this->result->fetch_assoc();
	}
	
	function fetchArray($resultType = self::FETCH_ASSOC)
	{
		return $this->result->fetch_array($resultType);
	}
	
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
 */
class DatabaseException extends FrameworkException {}

/**
 * @package ManiaLib
 * @subpackage Database
 */
class DatabaseQueryException extends DatabaseException {}

?>
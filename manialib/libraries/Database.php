<?php
/**
 * MySQL abstraction layer
 * 
 * Usage example:
 * <code>
 * <?php
 * 
 * require_once(APP_FRAMEWORK_LIBRARIES_PATH.'Database.php');
 * 
 * try
 * {
 *     $database = DatabaseFactory::getConnection();
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
 * Database connection factory
 * Helps retrieving DB connection instances from anywhere in the code
 * @package ManiaLib
 * @subpackage Database
 */
abstract class DatabaseFactory
{
	/**
	 * @var array[DatabaseConnection]
	 */
	static protected $connections = array();
	
	/**
	 * @return DatabaseConnection
	 */
	static function getConnection(
		$host=APP_DATABASE_HOST, 
		$user=APP_DATABASE_USER, 
		$password=APP_DATABASE_PASSWORD,
		$database=APP_DATABASE_NAME,
		$useSSL = false,
		$forceNewConnection=false)
	{
		$identifier = $user.'@'.$host;
		
		if(!array_key_exists($identifier, self::$connections) 
			|| self::$connections[$identifier]===null)
		{
			self::$connections[$identifier] = new DatabaseConnection(
				$host, $user, $password, $database, $useSSL, $forceNewConnection);				
		}
		elseif($database)
		{
			self::$connections[$identifier]->select($database);
		}
		self::$connections[$identifier]->incrementReferenceCount();
		return self::$connections[$identifier];
	}
	
	/**
	 * DO NOT USE THIS DIRECTLY !
	 * Use DatabaseConnection::disconnect() instead
	 */
	static function deleteConnection($user, $host)
	{
		$identifier = $user.'@'.$host;
		if(array_key_exists($identifier, self::$connections))
		{
			unset(self::$connections[$identifier]);
		}
	}
}

/**
 * Database connection instance
 * @package ManiaLib
 * @subpackage Database
 */
class DatabaseConnection
{
	protected $connection;
	protected $host;
	protected $user;
	protected $password;
	protected $database;
	protected $clientFlags;
	protected $referenceCount;
	
	function __construct($host, $user, $password, $database=null, 
		$useSSL=false, $forceNewConnection=false)
	{
		// Init
		$this->host = $host;
		$this->user = $user;
		$this->password = $password;
		$this->clientFlags = 0;
		$this->referenceCount = 0;
		
		// Flags
		if($useSSL)
		{
			$this->clientFlags = MYSQL_CLIENT_SSL;
		}
		
		// Connection
		$this->connection = mysql_connect(
			$this->host,
			$this->user,
			$this->password,
			$forceNewConnection,
			$this->clientFlags
		);
				
		// Success ?
		if(!$this->connection)
		{
			throw new DatabaseConnectionException;
		}
		
		// Select
		if($database)
		{
			$this->select($database);	
		}
		
		// Default Charset : UTF8
		self::setCharset('utf8');
	}
	
	function setCharset($charset)
	{
		if(!mysql_set_charset($charset, $this->connection))
		{
			throw new DatabaseException;
		}
	}
	
	function select($database)
	{
		if($database != $this->database)
		{
			$this->database = $database;
			if(!mysql_select_db($this->database, $this->connection))
			{
				throw new DatabaseSelectionException($this->connection);
			}
		}
	}
		
	function quote($string)
	{
		return '\''.mysql_real_escape_string($string, $this->connection).'\'';
	}
	
	/**
	 * @param string The query
	 * @return DatabaseRecordSet
	 */
	function execute($query)
	{
		$result = mysql_query($query, $this->connection);
		if(!$result)
		{
			throw new DatabaseQueryException($query);
		}
		return new DatabaseRecordSet($result);
	}
	
	function affectedRows()
	{
		return mysql_affected_rows($this->connection);
	}
	
	function insertID()
	{
		return mysql_insert_id($this->connection);
	}
	
	function isConnected()
	{
		return (!$this->connection); 
	}
	
	function disconnect()
	{
		$this->referenceCount--;
		if($this->referenceCount == 0)
		{
			if(!mysql_close($this->connection))
			{
				throw new DatabaseDisconnectionException;
			}
			$this->connection = null;
			DatabaseFactory::deleteConnection($this->user, $this->host);
		}
	}
	
	function getDatabase()
	{
		return $this->database;
	}
		
	function incrementReferenceCount()
	{
		$this->referenceCount++;
	}
}

/**
 * Database query result
 * @package ManiaLib
 * @subpackage Database
 */
class DatabaseRecordSet
{
	const FETCH_ASSOC = MYSQL_ASSOC;
	const FETCH_NUM = MYSQL_NUM;
	const FETCH_BOTH = MYSQL_BOTH;

	protected $result;
	
	function __construct($result)
	{
		$this->result = $result;
	}
	
	function fetchRow()
	{
		return mysql_fetch_row($this->result);
	}
	
	function fetchAssoc()
	{
		return mysql_fetch_assoc($this->result);
	}
	
	function fetchArray($resultType = self::FETCH_ASSOC)
	{
		return mysql_fetch_array($this->result, $resultType);
	}
	
	function fetchStdObject()
	{
		return mysql_fetch_object($this->result);
	}
	
	function fetchObject($className, array $params=array() )
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
 */
class DatabaseException extends FrameworkException {}

/**
 * @package ManiaLib
 * @subpackage Database
 */
class DatabaseConnectionException extends DatabaseException {}

/**
 * @package ManiaLib
 * @subpackage Database
 */
class DatabaseDisconnectionException extends DatabaseException {}

/**
 * @package ManiaLib
 * @subpackage Database
 */
class DatabaseSelectionException extends DatabaseException
{
	function __construct($dummy=null, $dummy2=null, Exception $previous=null, $logException=true)
	{
		parent::__construct(mysql_error(), mysql_errno(), $previous, $logException);
	}
}

/**
 * @package ManiaLib
 * @subpackage Database
 */
class DatabaseQueryException extends DatabaseException
{
	function __construct($query, $dummy2=null, Exception $previous=null, $logException=true)
	{
		parent::__construct(mysql_error(), mysql_errno(), $previous, false);
		$this->addOptionalInfo('Query', $query);
		if($logException)
		{
			$this->iLog();
		}
	}
}

?>
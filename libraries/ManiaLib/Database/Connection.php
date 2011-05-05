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
 * Database connection. This is where the magic happens!
 */
class Connection
{
	/**
	 * @var array[\ManiaLib\Database\ConnectionParams]
	 */
	static protected $connections = array();
	
	/**
	 * @var \ManiaLib\Database\Config	
	 */
	protected $config;
	/**
	 * @var \ManiaLib\Database\ConnectionsParams
	 */
	protected $params;
	/**
	 * MySQL connection ressource
	 */
	protected $connection;
	/**
	 * Current charset
	 * @var string
	 */
	protected $charset;
	/**
	 * Currently selected database
	 * @vat string
	 */
	protected $database;
	/**
	 * @var int
	 */
	protected $transactionRefCount;
	/**
	 * @var bool
	 */
	protected $transactionRollback;

	/**
	 * The easiest way to retrieve a database connection. Works as a singleton,
	 * and returns a connection with the default parameters
	 * @return \ManiaLib\Database\Connection
	 */
	static function getInstance()
	{
		if(\array_key_exists('default', self::$connections))
		{
			return self::$connections['default'];
		}

		$config = Config::getInstance();

		$params = new ConnectionParams();
		$params->id = 'default';
		$params->host = $config->host;
		$params->user = $config->user;
		$params->password = $config->password;
		$params->database = $config->database;
		$params->charset = $config->charset;

		return self::factory($params);
	}

	/**
	 * Advanced connection retrieval. You can have multiple instances of the
	 * Connection object so you can work with several MySQL servers. If you don't
	 * give any parameters, it will work as self::getInstance()
	 * @return \ManiaLib\Database\Connection
	 */
	static function factory(ConnectionParams $params)
	{
		if(!$params->id)
		{
			throw new Exception('ConnectionParams object has no ID');
		}
		if(!array_key_exists($params->id, self::$connections))
		{
			self::$connections[$params->id] = new self($params);
		}
		return self::$connections[$params->id];
	}

	protected function __construct(ConnectionParams $params)
	{
		$this->config = Config::getInstance();
		$this->params = $params;
		
		$this->connection = mysql_connect(
			$this->params->host,
			$this->params->user,
			$this->params->password,
			null,
			$this->params->ssl?MYSQL_CLIENT_SSL:null);
				
		if(!$this->connection)
		{
			throw new ConnectionException();
		}

		$this->setCharset($this->params->charset);
		$this->select($this->params->database);
	}
	
	function setCharset($charset)
	{
		if($charset != $this->charset)
		{
			$this->charset = $charset;
			if(!mysql_set_charset($charset, $this->connection))
			{
				throw new Exception('Couldn\'t set charset: '.$charset);
			}
		}
	}
	
	function select($database)
	{
		if($database && $database != $this->database)
		{
			$this->database = $database;
			if(!mysql_select_db($this->database, $this->connection))
			{
				throw new SelectionException(mysql_error(), mysql_errno());
			}
		}
	}

	function quote($string)
	{
		return '\''.mysql_real_escape_string($string, $this->connection).'\'';
	}
	
	/**
	 * @return RecordSet
	 */
	function execute($query)
	{
		$mtime = microtime(true);
		if(func_num_args() > 1)
		{
			$query = call_user_func_array('sprintf', func_get_args());
		}
		$result = mysql_query($query, $this->connection);
		if(!$result)
		{
			throw new QueryException(mysql_error().': '.$query, mysql_errno());
		}
		if($this->config->queryLog)
		{
			$mtime = (microtime(true) - $mtime)*1000;
			$message = str_pad(number_format($mtime, 3). ' ms', 10, ' ').$query;
			\ManiaLib\Log\Logger::log($message, true, $this->config->queryLogFilename);
		}
		if($this->config->slowQueryLog)
		{
			$mtime = (microtime(true) - $mtime)*1000;
			if($mtime > $this->config->slowQueryThreshold)
			{
				$message = str_pad(number_format($mtime, 3). ' ms', 10, ' ').$query;
				\ManiaLib\Log\Logger::log($message, true, $this->config->slowQueryLogFilename);
			}
		}
		return new RecordSet($result);
	}
	
	/**
	 * Execute a query or fetch it from Memcache.
	 */
	function executeCache($ttl, $query)
	{
		$args = func_get_args();
		array_shift($args);
		if(func_num_args() > 2)
		{
			$query = call_user_func_array('sprintf', $args);
		}
		
		$key = \ManiaLib\Cache\Cache::getPrefix().'mysql_'.md5($query);
		$cache = \ManiaLib\Cache\Cache::factory(\ManiaLib\Cache\MEMCACHE);
		$result = $cache->fetch($key);
		
		if(!$result)
		{
			$result = call_user_func_array(array($this, 'execute'), $args); 
			$cache->add($key, $result, $ttl);
		}
		
		return $result;
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

	function getDatabase()
	{
		return $this->database;
	}
	
	/**
	 * ACID Transactions
	 * ONLY WORKS WITH INNODB TABLES !
	 * 
	 * ----
	 * 
	 * It handles EXPERIMENTAL (== never tested!!!) nested transactions
	 * one "BEGIN" on the first call of beginTransaction
	 * one "COMMIT" on the last call of commitTransaction (when the ref count is 1)
	 * one "ROLLBACK" on the first call of rollbackTransaction
	 */
	function beginTransaction()
	{
		if($this->transactionRollback)
		{
			throw new Exception('Transaction must be rollback\'ed!');
		}
		if($this->transactionRefCount === null)
		{
			$this->execute('BEGIN');
			$this->transactionRefCount = 1;
		}
		else
		{
			$this->transactionRefCount++;
		}
	}
	
	/**
	 * @see self::beginTransaction()
	 */
	function commitTransaction()
	{
		if($this->transactionRollback)
		{
			throw new Exception('Transaction must be rollback\'ed!');
		}
		if($this->transactionRefCount === null)
		{
			throw new Exception('Transaction was not previously started');
		}
		elseif($this->transactionRefCount > 1)
		{
			$this->transactionRefCount--;
		}
		elseif($this->transactionRefCount == 1)
		{
			$this->execute('COMMIT');
			$this->transactionRefCount = null;
		}
		else
		{
			throw new Exception(
				'Transaction reference counter error: '.
				print_r($this->transactionRefCount, true));
		}
	}
	
	/**
	 * @see self::beginTransaction()
	 */
	function rollbackTransaction()
	{
		if(!$this->transactionRollback)
		{
			$this->transactionRollback = true;
			$this->execute('ROLLBACK');
		}
		
		if($this->transactionRefCount > 1)
		{
			$this->transactionRefCount--;
		}
		elseif($this->transactionRefCount == 1)
		{
			$this->transactionRefCount = null;
			$this->transactionRollback = null;
		}
		else
		{
			throw new Exception(
				'Transaction reference counter error: '.
				print_r($this->transactionRefCount, true));
		}
	}
	
	function doTransaction($callback)
	{
		try 
		{
			$this->beginTransaction();
			call_user_func($callback);
			$this->commitTransaction();
		} 
		catch (\Exception $e) 
		{
			$this->rollbackTransaction();
			throw $e;
		}
	}
}

class Exception extends \Exception {}
class ConnectionException extends Exception {}
class SelectionException extends Exception {}
class QueryException extends Exception {}

?>
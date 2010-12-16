<?php

class ManiaLib_Database_Connection
{
	static protected $instance;
	/**
	 * @var ManiaLib_Database_Config	
	 */
	protected $config;
	protected $connection;
	protected $host;
	protected $user;
	protected $password;
	protected $database;
	protected $charset;
	
	/**
	 * @return ManiaLib_Database_Connection
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
	 * @ignore
	 */
	protected function __construct()
	{
		$this->config = ManiaLib_Config_Loader::$config->database;
		
		$this->host = $this->config->host;
		$this->user = $this->config->user;
		$this->password = $this->config->password;
		
		$this->connection = mysql_connect($this->host, $this->user, $this->password);
				
		if(!$this->connection)
		{
			throw new ManiaLib_Database_ConnectionException();
		}

		$this->setCharset($this->config->charset);
		$this->select($this->config->database);
	}
	
	function setCharset($charset)
	{
		if($charset != $this->charset)
		{
			$this->charset = $charset;
			if(!mysql_set_charset($charset, $this->connection))
			{
				throw new ManiaLib_Database_Exception('Couldn\'t set charset: '.$charset);
			}
		}
	}
	
	function select($database)
	{
		if($database != $this->database)
		{
			$this->database = $database;
			if(!mysql_select_db($this->database, $this->connection))
			{
				throw new ManiaLib_Database_SelectionException(mysql_error(), mysql_errno());
			}
		}
	}

	function quote($string)
	{
		return '\''.mysql_real_escape_string($string, $this->connection).'\'';
	}
	
	/**
	 * @return ManiaLib_Database_RecordSet
	 */
	function execute($query)
	{
		$mtime = microtime(true);
		$result = mysql_query($query, $this->connection);
		if(!$result)
		{
			throw new ManiaLib_Database_QueryException(mysql_error(), mysql_errno());
		}
		if($this->config->queryLog)
		{
			$mtime = (microtime(true) - $mtime)*1000;
			$message = str_pad(number_format($mtime, 3). ' ms', 10, ' ').$query;
			ManiaLib_Log_Logger::log($message, true, $this->config->queryLogFilename);
		}
		if($this->config->slowQueryLog)
		{
			$mtime = (microtime(true) - $mtime)*1000;
			if($mtime > $this->config->slowQueryThreshold)
			{
				$message = str_pad(number_format($mtime, 3). ' ms', 10, ' ').$query;
				ManiaLib_Log_Logger::log($message, true, $this->config->slowQueryLogFilename);
			}
		}
		return new ManiaLib_Database_RecordSet($result);
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
}

class ManiaLib_Database_Exception extends Exception {}
class ManiaLib_Database_ConnectionException extends ManiaLib_Database_Exception {}
class ManiaLib_Database_SelectionException extends ManiaLib_Database_Exception {}
class ManiaLib_Database_QueryException extends ManiaLib_Database_Exception {}

?>

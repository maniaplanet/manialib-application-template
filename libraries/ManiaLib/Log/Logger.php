<?php

class ManiaLib_Log_Logger
{
	const LOG_DATE = true;
	const LOG_NO_DATE = false;
	
	protected static $loaded = false;
	protected static $path;
	protected static $prefix;
	protected static $errorLog;
	protected static $userLog;
	protected static $debugLog;
	protected static $loaderLog;
	
	static function info($message, $addDate = true)
	{
		if(self::load())
		{
			self::log($message, $addDate, self::$debugLog);
		}
	}
	
	static function error($message, $addDate = true)
	{
		if(self::load())
		{
			self::log($message, $addDate, self::$errorLog);
		}
	}
	
	static function user($message, $addDate = true)
	{
		if(self::load())
		{
			self::log($message, $addDate, self::$userLog);
		}
	}
	
	static function loader($message, $addDate = true)
	{
		if(self::load())
		{
			self::log($message, $addDate, self::$loaderLog);
		}
	}
	
	/**
	 * Writes a message in the debug log. If you can, use the other methods (info, error, user)
	 * 
	 * @param string The message
	 * @param boolean Whether to add the date to the message
	 * @param string The log filename
	 */
	static function log($message, $addDate = self::LOG_DATE, $logFilename = 'debug.log')
	{
		if(self::load())
		{
			$message = ($addDate?date('c'):'').'  '.print_r($message, true)."\n";
			$filename = self::$path.self::$prefix.$logFilename;
			file_put_contents($filename, $message, FILE_APPEND);
		}
	}
	
	static protected function load()
	{
		if(!self::$loaded)
		{
			if(ManiaLib_Config_Loader::$config)
			{
				if($config = ManiaLib_Config_Loader::$config->log)
				{
					if(file_exists($path = ManiaLib_Config_Loader::$config->log->path))
					{
						self::$path = $path;
						self::$prefix = $config->prefix ? $config->prefix.'-' : ''; 
						
						self::$debugLog = $config->debug;
						self::$errorLog = $config->error;
						self::$userLog = $config->user;
						self::$loaderLog = $config->loader;
						
						self::$loaded = true;
					}
				}
			}
		}
		return !empty(self::$path);
	}
}

?>
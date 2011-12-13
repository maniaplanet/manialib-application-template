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

namespace ManiaLib\Log;

/**
 * Logger
 */
class Logger
{
	const LOG_DATE = true;
	const LOG_NO_DATE = false;
	
	protected static $loaded = false;
	protected static $path;
	protected static $prefix;
	protected static $errorLog;
	protected static $userLog;
	protected static $debugLog;
	
	static function info($message, $addDate = true)
	{
		self::log($message, $addDate, self::$debugLog);
	}
	
	static function error($message, $addDate = true)
	{
		self::log($message, $addDate, self::$errorLog);
	}
	
	static function user($message, $addDate = true)
	{
		self::log($message, $addDate, self::$userLog);
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
			$config = Config::getInstance();
			if(file_exists($path = $config->path))
			{
				self::$path = $path;
				self::$prefix = $config->prefix ? $config->prefix.'-' : ''; 
				
				self::$debugLog = $config->debug;
				self::$errorLog = $config->error;
				self::$userLog = $config->user;
				
				self::$loaded = true;
			}
		}
		return !empty(self::$path);
	}
}

?>
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

namespace ManiaLib\Application;

/**
 * Default bootstrapper
 */
abstract class Bootstrapper
{
	static $configFile;
	static $errorReporting = E_ALL;
	static $errorHandlingClass = '\ManiaLib\Application\ErrorHandling';
	static $errorHandler = 'exceptionErrorHandler';
	static $exceptionHandler = 'exceptionHandler';
	static $fatalExceptionHandler = 'fatalExceptionHandler';
	/**
	 * Microtime, which is set just at the begining of run() for benchmarking
	 * purpose
	 * @var float
	 */
	static $mtime;
	
	final static function run()
	{
		static::$mtime = microtime(true);
		error_reporting(static::$errorReporting);
		set_error_handler(array(static::$errorHandlingClass, static::$errorHandler));
		
		try 
		{
			$loader = \ManiaLib\Config\Loader::getInstance();
			$loader->setConfigFilename(static::$configFile);
			$loader->smartLoad();
			
			static::onPreDispatch();
			
			try 
			{
				static::onDispatch();		
			}
			catch(\Exception $exception)
			{
				call_user_func(
				array(
					static::$errorHandlingClass, 
					static::$exceptionHandler), 
				$exception);
			}
		}
		catch(\Exception $exception)
		{
			call_user_func(
				array(
					static::$errorHandlingClass, 
					static::$fatalExceptionHandler), 
				$exception);
		}
		
		\ManiaLib\Benchmark\ApplicationRequests::touch(static::$mtime);
	}
	
	/**
	 * Called between config loading and application dispatching.
	 * Typically used to load stuff such as i18n, route map etc. 
	 */
	static protected function onPreDispatch()
	{
		if(\ManiaLib\I18n\Config::getInstance()->dynamic)
		{
			$loader = \ManiaLib\I18n\Loader::getInstance();
			$loader->smartLoad();
		}
	}
	
	/**
	 * Actually dispatch the application
	 * Exception thrown from here will be catched by the callback defined by 
	 * array(static::$errorHandlingClass, static::$exceptionHandler)
	 */
	static protected function onDispatch()
	{
		\ManiaLib\Application\Controller::dispatch();
	}
}

?>
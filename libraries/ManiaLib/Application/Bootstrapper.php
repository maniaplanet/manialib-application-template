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

	static $errorReporting = E_ALL;
	static $errorHandlingClass = '\ManiaLib\Application\ErrorHandling';
	static $errorHandler = 'exceptionErrorHandler';
	static $fatalExceptionHandler = 'fatalExceptionHandler';

	final static function run()
	{
		error_reporting(static::$errorReporting);
		set_error_handler(array(static::$errorHandlingClass, static::$errorHandler));

		try
		{
			static::onDispatch();
		}
		catch(\Exception $exception)
		{
			call_user_func(
				array(
				static::$errorHandlingClass,
				static::$fatalExceptionHandler), $exception);
		}
	}

	/**
	 * Actually dispatch the application
	 * Exception thrown from here will be catched by the callback defined by 
	 * array(static::$errorHandlingClass, static::$exceptionHandler)
	 */
	static protected function onDispatch()
	{
		\ManiaLib\Config\NewLoader::load();
		Dispatcher::getInstance()->run();
	}

}

?>
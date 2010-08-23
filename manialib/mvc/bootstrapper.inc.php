<?php
/**
 * MVC application bootstrapper
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 * @package ManiaLib_MVC
 */

// All errors are catched by the error handler
error_reporting(E_ALL);

// Checks the APP_MVC_FRAMEWORK constant
if(!APP_MVC_FRAMEWORK)
{
	trigger_error('APP_MVC_FRAMEWORK must be true', E_USER_ERROR);
}

// Register autoload functions
spl_autoload_register('__autoload');
spl_autoload_register('autoload_mvc_framework');

// Date config
date_default_timezone_set(APP_DEFAULT_TIMEZONE);

// Set error handling
set_error_handler(array('ErrorHandling', 'exceptionErrorHandler'));
set_exception_handler(array('ErrorHandling', 'exceptionHandler'));
 
try
{
	ActionController::dispatch();
}
catch(Exception $e)
{
	FrameworkException::handle($e);
}

?>
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

// Load frameworks
require_once(APP_FRAMEWORK_PATH.'manialib.inc.php');
require_once(APP_MVC_FRAMEWORK_PATH.'mvc.inc.php');

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
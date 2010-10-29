<?php
/**
 * MVC application bootstrapper
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 * @package ManiaLib_MVC
 * @ignore
 */


error_reporting(E_ALL);

if(!APP_MVC_FRAMEWORK)
{
	trigger_error('APP_MVC_FRAMEWORK must be true', E_USER_ERROR);
}

/**
 * @ignore
 */
require_once(APP_FRAMEWORK_PATH.'manialib.inc.php');
/**
 * @ignore
 */
require_once(APP_MVC_FRAMEWORK_PATH.'mvc.inc.php');

date_default_timezone_set(APP_DEFAULT_TIMEZONE);
//set_error_handler(array('ErrorHandling', 'exceptionErrorHandler'));
set_exception_handler(array('ErrorHandling', 'exceptionHandler'));
 
try
{
	ActionController::dispatch();
}
catch(Exception $exception)
{
	ErrorHandling::exceptionHandler($exception);
}

?>
<?php

// All errors are catched to the error handler
error_reporting(E_ALL);

// Forces ManiaLib to use the right request engine
define('APP_FRAMEWORK_REQUEST_ENGINE_CLASS', 'RequestEngineMVC');

// Load configs
require_once(dirname(__FILE__).'/config/config.php');
require_once(dirname(__FILE__).'/manialib/manialib.inc.php');
require_once(dirname(__FILE__).'/manialib/mvc/mvc.inc.php');

// Register different autoload functions
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
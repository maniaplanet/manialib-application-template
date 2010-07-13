<?php

error_reporting(E_ALL);

require_once(dirname(__FILE__).'/config/config.php');
require_once(dirname(__FILE__).'/manialib/manialib.inc.php');
require_once(dirname(__FILE__).'/manialib/mvc/mvc.inc.php');

spl_autoload_register('__autoload');
spl_autoload_register('autoload_mvc_framework');

// Date config
date_default_timezone_set(APP_DEFAULT_TIMEZONE);

// Error handling
set_error_handler(array('ErrorHandling', 'exceptionErrorHandler'));
set_exception_handler(array('ErrorHandling', 'exceptionHandler'));

// FIXME Certains composants de Manialib utilise RequestEngine alors qu'ils devraient utiliser RequestEngineMVC. Comment Faire ?
try
{
	ActionController::dispatch();
}
catch(Exception $e)
{
	FrameworkException::handle($e);
}

?>
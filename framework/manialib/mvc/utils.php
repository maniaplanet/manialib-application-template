<?php 
/**
 * MVC framework functions
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib_MVC
 */

/**
 * Class autoloader for the MVC framework
 * 
 * To use with spl_autload_register() to register it as a class autoloader in PHP
 */
function autoload_mvc_framework($className)
{
	if(file_exists($path = APP_MVC_FILTERS_PATH.$className.'.class.php'))
	{
		require_once($path);
		return true;
	}
	if(file_exists($path = APP_MVC_FRAMEWORK_FILTERS_PATH.$className.'.class.php'))
	{
		require_once($path);
		return true;
	}
	if(file_exists($path = APP_MVC_FRAMEWORK_LIBRARIES_PATH.$className.'.class.php'))
	{
		require_once($path);
		return true;
	}
	if(file_exists($path = APP_MVC_FRAMEWORK_EXCEPTIONS_PATH.$className.'.class.php'))
	{
		require_once($path);
		return true;
	}
	return false;
}

?>
<?php
/**
 * Default config file
 *
 * You shouldn't modify anything here. Use config.php to override
 * constants instead.
 *
 * @author Maxime Raoust
 * @package Manialib
 */

//This doesn't work well with USE_SHORT_MANIALINK set to true
if(!defined('APP_PATH'))
{
	/**
	 * Path to the root of your application
	 */
	define('APP_PATH', dirname(__FILE__) . '/../');
}
if(!defined('APP_URL_BASE'))
{
	/**
	 * Base URL of your application. If your manialink is hosted at
	 * "http//yourhost. com/mymanialink/", you should put here "http://yourhost.
	 * com/". Don't forget the trailing slash.
	 */
	if(isset($_SERVER['SERVER_PROTOCOL']) && isset($_SERVER['HTTP_HOST']))
	{
		$protocol = preg_replace('/([^\/]*).*/i','$1',$_SERVER['SERVER_PROTOCOL']);
		define('APP_URL_BASE', strtolower($protocol).'://'.$_SERVER['HTTP_HOST'].'/');
	}
	else
	{
		define('APP_URL_BASE', '');
	}
}
if(!defined('APP_URL_PATH'))
{
	/**
	 * URL Path of your application. If your manialink is hosted at "http:
	 * //yourhost. com/mymanialink/", you should put here "mymanialink/". Don't
	 * forget the trailing slash.
	 */
	$str = '';
	if(isset($_SERVER['REQUEST_URI']))
	{
		$path = explode('/',$_SERVER['REQUEST_URI']);
		for($i = 1; $i < count($path) - 1; $i++)
		{
			$str .= $path[$i].'/';
		}
	}
	define('APP_URL_PATH', $str);
}
if(!defined('APP_URL'))
{
	/**
	 * Complete URL of your application. You shouldn't have to change this
	 * value.
	 */
	define('APP_URL', APP_URL_BASE . APP_URL_PATH);
}
if(!defined('APP_FRAMEWORK_PATH'))
{
	/**
	 * Path to the framework (ie. the manialib/ directory)
	 */
	define('APP_FRAMEWORK_PATH', APP_PATH . 'manialib/');
}
if(!defined('APP_FRAMEWORK_LIBRARIES_PATH'))
{
	/**
	 * Path to the framework libraries
	 */
	define('APP_FRAMEWORK_LIBRARIES_PATH', APP_FRAMEWORK_PATH . 'libraries/');
}
if(!defined('APP_FRAMEWORK_EXCEPTIONS_PATH'))
{
	/**
	 * Path to the framework exceptions
	 */
	define('APP_FRAMEWORK_EXCEPTIONS_PATH', APP_FRAMEWORK_PATH . 'exceptions/');
}
if(!defined('APP_FRAMEWORK_GUI_TOOLKIT_PATH'))
{
	/**
	 * Path to the GUI toolkit
	 */
	define('APP_FRAMEWORK_GUI_TOOLKIT_PATH', APP_FRAMEWORK_PATH . 'gui-toolkit/');
}
if(!defined('APP_LIBRARIES_PATH'))
{
	/**
	 * Path to the user libraries
	 */
	define('APP_LIBRARIES_PATH', APP_PATH . 'libraries/');
}
if(!defined('APP_LANGS_PATH'))
{
	/**
	 * Path to the langs
	 */
	define('APP_LANGS_PATH', APP_PATH . 'langs/');
}
if(!defined('APP_LOGS_PATH'))
{
	/**
	 * Path to the logs
	 */
	define('APP_LOGS_PATH', APP_PATH . 'logs/');
}
if(!defined('APP_INCLUDE_PATH'))
{
	/**
	 * Misc include path, to put views anything that is not a class
	 */
	define('APP_INCLUDE_PATH', APP_PATH . 'include/');
}
if(!defined('APP_CONFIG_PATH'))
{
	/**
	 * Path to the config
	 */
	define('APP_CONFIG_PATH', APP_PATH . 'config/');
}
if(!defined('APP_WWW_PATH'))
{
	/**
	 * Path to the webroot
	 */
	define('APP_WWW_PATH', APP_PATH);
}
if(!defined('APP_IMAGE_DIR_URL'))
{
	/**
	 * URL of the images directory
	 */
	define('APP_IMAGE_DIR_URL', APP_URL . 'images/');
}
if(!defined('APP_DATA_DIR_URL'))
{
	/**
	 * URL of the data directory
	 */
	define('APP_DATA_DIR_URL', APP_URL . 'data/');
}
if(!defined('APP_ERROR_LOG'))
{
	/**
	 * Error log
	 */
	define('APP_ERROR_LOG', APP_LOGS_PATH . 'error.log');
}
if(!defined('APP_USER_ERROR_LOG'))
{
	/**
	 * Error log
	 */
	define('APP_USER_ERROR_LOG', APP_LOGS_PATH . 'user-error.log');
}
if(!defined('APP_DEBUG_LOG'))
{
	/**
	 * Debug log
	 */
	define('APP_DEBUG_LOG', APP_LOGS_PATH . 'debug.log');
}
if(!defined('APP_MANIALINK'))
{
	/**
	 * Name of your short Manialink. Note that the short Manialink <b>"
	 * manialibdev" </b> redirects to <b>"http://localhost/manialib/"</b> for
	 * easy access to your local developement version
	 */
	define('APP_MANIALINK', 'manialib');
}
if(!defined('APP_USE_SHORT_MANIALINKS'))
{
	/**
	 * <b>THIS IS EXPERIMENTAL! If you don't really need to use short
	 * manialinks, you should leave this as "false"</b>. If you use the short
	 * manialinks option, rename "use_short_manialinks .htaccess" to .htaccess
	 * and check that Apache mod rewrite is enabled on your server.
	 */
	define('APP_USE_SHORT_MANIALINKS', false);
}
if(!defined('APP_DEFAULT_TIMEZONE'))
{
	/**
	 * Default time zone of the server
	 */
	define('APP_DEFAULT_TIMEZONE', 'Europe/Paris');
}
if(!defined('APP_TIMEZONE_NAME'))
{
	/**
	 * Human readable name of the time zone in case you need to print it
	 */
	define('APP_TIMEZONE_NAME', 'GMT+1');
}
if(!defined('APP_LANG_ENGINE_MODE'))
{
	/**
	 * Lang engine mode: if 0, the lang files will be included to be used as
	 * normal Manialink dictionary files. If 1, the dynamic lang engine will be
	 * loaded and translation strings will be obtained with the __() function
	 */
	define('APP_LANG_ENGINE_MODE', 1);
}
if(!defined('APP_DEBUG_LEVEL'))
{
	/**
	 * Debug level can be either 0 or 1. Put 1 for your developement version to
	 * get verbose error messages etc. Don't forget to use 0 for your production
	 * version
	 */
	define('APP_DEBUG_LEVEL', 0); // 0 or 1
}
if(!defined('APP_DATABASE_HOST'))
{
	/**
	 * Database host
	 */
	define('APP_DATABASE_HOST', 'localhost');
}
if(!defined('APP_DATABASE_USER'))
{
	define('APP_DATABASE_USER', 'root');
}
if(!defined('APP_DATABASE_PASSWORD'))
{
	/**
	 * Database user
	 */
	define('APP_DATABASE_PASSWORD', '');
}
if(!defined('APP_DATABASE_NAME'))
{
	/**
	 * Database name
	 */
	define('APP_DATABASE_NAME', 'manialib');
}
if(!defined('APP_DATABASE_PREFIX'))
{
	/**
	 * Table names prefix in the database
	 */
	define('APP_DATABASE_PREFIX', 'manialib_');
}

?>
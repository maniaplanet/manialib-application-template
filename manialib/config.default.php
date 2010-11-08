<?php
/**
 * Framework default config
 * 
 * This is the default configuration file. You shouldn't modify anything in this
 * file. Instead, override the constants you want in your "config.php" file.
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

if(!defined('APP_PATH'))
{
	/**
	 * Path to your application on the hard drive
	 */
	define('APP_PATH', dirname(__FILE__) . '/../');
}
if(!defined('APP_URL_BASE'))
{
	if(isset($_SERVER) && isset($_SERVER['SERVER_PROTOCOL']) && isset($_SERVER['HTTP_HOST']))
	{
		/**
		 * Base URL of your application
		 * 
		 * If your manialink is hosted at "http//yourhost. com/mymanialink/", you 
		 * should put here "http://yourhost.com/". Don't forget the trailing slash.
		 */
		define('APP_URL_BASE', strtolower(preg_replace('/([^\/]*).*/i','$1',$_SERVER['SERVER_PROTOCOL'])).'://'.$_SERVER['HTTP_HOST'].'/');
	}
	else
	{
		/**
		 * @ignore
		 */
		define('APP_URL_BASE', '');
	}
}
if(!defined('APP_URL_PATH'))
{
	/**
	 * URL path of your application
	 * 
	 * If your manialink is hosted at "http://yourhost. com/mymanialink/", you 
	 * should put here "mymanialink/". Don't forget the trailing slash.
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
	 * Complete URL of your application. 
	 * 
	 * You shouldn't have to change this value.
	 */
	define('APP_URL', APP_URL_BASE . APP_URL_PATH);
}
if(!defined('APP_FRAMEWORK_PATH'))
{
	/**
	 * Framework path
	 * 
	 * This is the path to the "manialib/" directory
	 */
	define('APP_FRAMEWORK_PATH', APP_PATH . 'manialib/');
}
if(!defined('APP_FRAMEWORK_LANGS_PATH'))
{
	/**
	 * Framework lang path
	 * 
	 * Default dictionaries of the framework
	 */
	define('APP_FRAMEWORK_LANGS_PATH', APP_FRAMEWORK_PATH . 'langs/');
}
if(!defined('APP_FRAMEWORK_LIBRARIES_PATH'))
{
	/**
	 * Framework libraries path
	 * 
	 * Path to the "libraries" directory of the framework
	 */
	define('APP_FRAMEWORK_LIBRARIES_PATH', APP_FRAMEWORK_PATH . 'libraries/');
}
if(!defined('APP_FRAMEWORK_GUI_TOOLKIT_PATH'))
{
	/**
	 * GUI Toolkit path
	 * 
	 * Path to the GUI Toolkit of the framework
	 */
	define('APP_FRAMEWORK_GUI_TOOLKIT_PATH', APP_FRAMEWORK_PATH . 'gui-toolkit/');
}
if(!defined('APP_LIBRARIES_PATH'))
{
	/**
	 * Libraries path
	 * 
	 * Path to the user libraries directory
	 */
	define('APP_LIBRARIES_PATH', APP_PATH . 'libraries/');
}
if(!defined('APP_LANGS_PATH'))
{
	/**
	 * Lang path
	 * 
	 * Directory containing the XML dictionaries for internationalizing your application
	 */
	define('APP_LANGS_PATH', APP_PATH . 'langs/');
}
if(!defined('APP_LOGS_PATH'))
{
	/**
	 * Logs path
	 * 
	 * Path to the logs directory
	 */
	define('APP_LOGS_PATH', APP_PATH . 'logs/');
}
if(!defined('APP_INCLUDE_PATH'))
{
	/**
	 * Include path
	 * 
	 * Misc include path, to put anything that is not a class
	 */
	define('APP_INCLUDE_PATH', APP_PATH . 'include/');
}
if(!defined('APP_CONFIG_PATH'))
{
	/**
	 * Config path
	 * 
	 * Path to the directory containing the config files of your application
	 */
	define('APP_CONFIG_PATH', APP_PATH . 'config/');
}
if(!defined('APP_WWW_PATH'))
{
	/**
	 * Webroot path
	 * 
	 * Path to the webroot of your application.
	 */
	define('APP_WWW_PATH', APP_PATH);
}
if(!defined('APP_IMAGE_DIR_URL'))
{
	/**
	 * Images directory URL
	 * 
	 * URL of the directory when you store the images of your application
	 */
	define('APP_IMAGE_DIR_URL', APP_URL . 'images/');
}
if(!defined('APP_DATA_DIR_URL'))
{
	/**
	 * Data directory URL
	 * 
	 * URL of the directory when your store misc data of your application
	 */
	define('APP_DATA_DIR_URL', APP_URL . 'data/');
}
if(!defined('APP_ERROR_LOG'))
{
	/**
	 * Error log
	 * 
	 * All the runtime errors will be logged in this file
	 */
	define('APP_ERROR_LOG', APP_LOGS_PATH . 'error.log');
}
if(!defined('APP_USER_ERROR_LOG'))
{
	/**
	 * User error log
	 * 
	 * All the user errors (eg.someone enterded a bad parameter in a form) will
	 * be logged in this file
	 */
	define('APP_USER_ERROR_LOG', APP_LOGS_PATH . 'user-error.log');
}
if(!defined('APP_DEBUG_LOG'))
{
	/**
	 * Debug log
	 * 
	 * All the debug messages will be logged in this file
	 */
	define('APP_DEBUG_LOG', APP_LOGS_PATH . 'debug.log');
}
if(!defined('APP_MANIALINK'))
{
	/**
	 * Short Manialink
	 * 
	 * Short Manialink of your application. You can define Short Manialinks on
	 * the Player Page at http://player.trackmania.com
	 * 
	 * Note that the Short Manialink <b>"manialibdev" </b> redirects to 
	 * <b>"http://localhost/manialib/"</b> for easy access to your local 
	 * developement version
	 */
	define('APP_MANIALINK', 'manialib');
}
if(!defined('APP_USE_SHORT_MANIALINKS'))
{
	/**
	 * Deprecated, please don't use it
	 * @deprecated
	 */
	define('APP_USE_SHORT_MANIALINKS', false);
}
if(!defined('APP_DEFAULT_TIMEZONE'))
{
	/**
	 * Time zone
	 * 
	 * Default time zone of the server
	 */
	define('APP_DEFAULT_TIMEZONE', 'Europe/Paris');
}
if(!defined('APP_TIMEZONE_NAME'))
{
	/**
	 * Time zone name
	 * 
	 * Human readable name of the time zone in case you need to print it
	 */
	define('APP_TIMEZONE_NAME', 'GMT+1');
}
if(!defined('APP_LANG_ENGINE_MODE'))
{
	/**
	 * Lang engine mode
	 * 
	 * If set to "1", it will use the <b>dynamic lang engine mode</b>. 
	 * The XML dicos will be loaded by LangEngine and you will be able 
	 * to create dynamic sentances.
	 * 
	 * If set to "0", it won't do anything so you can use them as standard
	 * Manialink dictionaries. Note that you will need to include the XML 
	 * files in your Manialink for localization to work.
	 * See Manialink::includeManialink() to do that
	 * 
	 * @see LangEngine
	 */
	define('APP_LANG_ENGINE_MODE', 1);
}
if(!defined('APP_DEBUG_LEVEL'))
{
	/**
	 * Debug level
	 * 
	 * <b>USE "0" FOR PRODUCTION ENVIRONEMENT !</b>
	 * 
	 * If <b>1</b>, all the debug messages and the errors will be outputed
	 * to the screen.
	 * 
	 * If <b>0</b>, only the user messages are shown in case of error
	 */
	define('APP_DEBUG_LEVEL', 0);
}
if(!defined('APP_DATABASE_HOST'))
{
	/**
	 * MySQL database hostname
	 */
	define('APP_DATABASE_HOST', 'localhost');
}
if(!defined('APP_DATABASE_USER'))
{
	/**
	 * MySQL database username
	 */
	define('APP_DATABASE_USER', 'root');
}
if(!defined('APP_DATABASE_PASSWORD'))
{
	/**
	 * MySQL database password
	 */
	define('APP_DATABASE_PASSWORD', '');
}
if(!defined('APP_DATABASE_NAME'))
{
	/**
	 * MySQL database name
	 */
	define('APP_DATABASE_NAME', 'manialib');
}
if(!defined('APP_DATABASE_CHARSET'))
{
	/**
	 * MySQL charset
	 * 
	 */
	define('APP_DATABASE_CHARSET', 'utf8');
}
if(!defined('APP_MVC_FRAMEWORK') && !defined('APP_FRAMEWORK_REQUEST_ENGINE_CLASS'))
{
	/**
	 * Request engine class
	 * 
	 * Define the right request engine class depending on the mvc framework usage
	 */
	define('APP_FRAMEWORK_REQUEST_ENGINE_CLASS', 'RequestEngine');
}
if(!defined('APP_MANIAHOME_SHOW_BUTTON'))
{
	/**
	 * Whether to show the ManiaHome favourite button
	 */
	define('APP_MANIAHOME_SHOW_BUTTON', true);
}
if(!defined('APP_MANIAHOME_NAME'))
{
	/**
	 * Name of your Manialink for the ManiaHome favourite button. 
	 * It can have special characters.
	 */
	define('APP_MANIAHOME_NAME', APP_MANIALINK);
}
if(!defined('APP_MANIAHOME_URL'))
{
	/**
	 * URL or short Manialink of your Manialink for the ManiaHome favourite button
	 */
	define('APP_MANIAHOME_URL', APP_MANIALINK);
}
if(!defined('APP_MANIAHOME_PICTURE'))
{
	/**
	 * URL of your banner for ManiaHome
	 */
	define('APP_MANIAHOME_PICTURE', null);
}

?>
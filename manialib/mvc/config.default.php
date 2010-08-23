<?php
/**
 * MVC framework default config
 * 
 * This is the default configuration file. You shouldn't modify anything in this
 * file. Instead, override the constants you want in your "config.php" file.
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib_MVC
 * @todo document the MVC constants
 */

if(!defined('APP_MVC_FRAMEWORK_PATH'))
{
	/**
	 * Path to the MVC framework directory
	 */
	define('APP_MVC_FRAMEWORK_PATH', dirname(__FILE__).'/');
}	
if(!defined('APP_MVC_FRAMEWORK_LIBRARIES_PATH'))
{
	/**
	 * Path to the MVC framework libraries directory
	 */
	define('APP_MVC_FRAMEWORK_LIBRARIES_PATH', APP_MVC_FRAMEWORK_PATH.'libraries/');
}	
if(!defined('APP_MVC_FRAMEWORK_EXCEPTIONS_PATH'))
{
	/**
	 * Path to the MVC framework exceptions directory
	 */
	define('APP_MVC_FRAMEWORK_EXCEPTIONS_PATH', APP_MVC_FRAMEWORK_PATH.'exceptions/');
}
if(!defined('APP_MVC_FRAMEWORK_FILTERS_PATH'))
{
	/**
	 * Path to the MVC framework filters directory
	 */
	define('APP_MVC_FRAMEWORK_FILTERS_PATH', APP_MVC_FRAMEWORK_PATH.'filters/');
}
if(!defined('APP_FRAMEWORK_REQUEST_ENGINE_CLASS'))
{
	/**
	 * @ignore
	 */
	define('APP_FRAMEWORK_REQUEST_ENGINE_CLASS', 'RequestEngineMVC');
}
if(!defined('APP_MVC_CONTROLLERS_PATH')) 
{
	/**
	 * Path to the controllers directory of your application
	 */
	define('APP_MVC_CONTROLLERS_PATH', APP_PATH.'controllers/');
}
if(!defined('APP_MVC_VIEWS_PATH'))
{
	/**
	 * Path to the views directory of your application
	 */
	define('APP_MVC_VIEWS_PATH', APP_PATH.'views/');
}
if(!defined('APP_MVC_FILTERS_PATH'))
{
	/**
	 * Path to the filters directory of your application
	 */
	define('APP_MVC_FILTERS_PATH', APP_PATH.'filters/');
}
if(!defined('APP_MVC_MODELS_PATH')) 
{
	/**
	 * Path to the models directory of your application
	 */
	define('APP_MVC_MODELS_PATH', APP_PATH.'models/');
}
if(!defined('URL_PARAM_NAME_CONTROLLER'))
{
	/**
	 * Name of the URL parameter for the controller name
	 */
	define('URL_PARAM_NAME_CONTROLLER', 'c');
}
if(!defined('URL_PARAM_DEFAULT_CONTROLLER'))
{
	/**
	 * Default controller of your application
	 */
	define('URL_PARAM_DEFAULT_CONTROLLER', 'home');
}
if(!defined('URL_PARAM_NAME_ACTION'))
{
	/**
	 * Name of the URL parameter for the action name
	 */
	define('URL_PARAM_NAME_ACTION', 'a');
}
if(!defined('URL_PARAM_DEFAULT_ACTION'))
{
	/**
	 * Default action when a controller hasn't defined its own default action.
	 * You shouldn't have to change this.
	 */
	define('URL_PARAM_DEFAULT_ACTION', 'index');
}
if(!defined('APP_MVC_USE_URL_REWRITE'))
{
	/**
	 * Does your application use Apache Mod Rewrite ?
	 * <ul>
	 * <li>Without mod rewrite: /index.php?c=some_controller&a=some_action</li>
	 * <li>With mod rewrite: /some_controller/some_action/</li>
	 * </ul>
	 */
	define('APP_MVC_USE_URL_REWRITE', false);
}

?>
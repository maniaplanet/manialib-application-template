<?php
/**
 * MVC framework default config
 * 
 * This is the default configuration file. You shouldn't modify anything in this
 * file. Instead, override the constants you want in your "config.php" file.
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 * @subpackage MVC
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
if(!defined('APP_MVC_FRAMEWORK_FILTERS_PATH'))
{
	/**
	 * Path to the MVC framework filters directory
	 */
	define('APP_MVC_FRAMEWORK_FILTERS_PATH', APP_MVC_FRAMEWORK_PATH.'filters/');
}
if(!defined('APP_MVC_FRAMEWORK_VIEWS_PATH'))
{
	/**
	 * Path to the MVC framework views directory
	 */
	define('APP_MVC_FRAMEWORK_VIEWS_PATH', APP_MVC_FRAMEWORK_PATH.'views/');
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
if(!defined('APP_MVC_DEFAULT_CONTROLLER'))
{
	/**
	 * Default controller of your application
	 */
	define('APP_MVC_DEFAULT_CONTROLLER', 'Home');
}
if(!defined('APP_MVC_DEFAULT_ACTION'))
{
	/**
	 * Default action when a controller hasn't defined its own default action.
	 * You shouldn't have to change this.
	 */
	define('APP_MVC_DEFAULT_ACTION', 'index');
}
if(!defined('APP_MVC_USE_URL_REWRITE'))
{
	/**
	 * Does your application use Apache Mod Rewrite ?
	 * <ul>
	 * <li>Without mod rewrite: /index.php?/some_controller/some_action/</li>
	 * <li>With mod rewrite: /some_controller/some_action/</li>
	 * </ul>
	 */
	define('APP_MVC_USE_URL_REWRITE', false);
}
if(!defined('APP_MVC_CONTROLLER_NAME_SEPARATOR'))
{
	/**
	 *  Controller name separator
	 *  eg. /some_request/ will be mapped to SomeRequestController
	 */
	define('APP_MVC_URL_SEPARATOR', '_');
}

?>
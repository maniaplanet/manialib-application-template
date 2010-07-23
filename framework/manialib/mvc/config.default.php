<?php
/**
 * Default MVC framework config
 */

if(!defined('APP_MVC_FRAMEWORK_PATH'))
{
	define('APP_MVC_FRAMEWORK_PATH', dirname(__FILE__).'/');
}	
if(!defined('APP_MVC_FRAMEWORK_LIBRARIES_PATH'))
{
	define('APP_MVC_FRAMEWORK_LIBRARIES_PATH', APP_MVC_FRAMEWORK_PATH.'libraries/');
}	
if(!defined('APP_MVC_FRAMEWORK_EXCEPTIONS_PATH'))
{
	define('APP_MVC_FRAMEWORK_EXCEPTIONS_PATH', APP_MVC_FRAMEWORK_PATH.'exceptions/');
}
if(!defined('APP_MVC_FRAMEWORK_FILTERS_PATH'))
{
	define('APP_MVC_FRAMEWORK_FILTERS_PATH', APP_MVC_FRAMEWORK_PATH.'filters/');
}
if(!defined('APP_FRAMEWORK_REQUEST_ENGINE_CLASS'))
{
	define('APP_FRAMEWORK_REQUEST_ENGINE_CLASS', 'RequestEngineMVC');
}
if(!defined('APP_MVC_CONTROLLERS_PATH'))   	 define('APP_MVC_CONTROLLERS_PATH', APP_PATH.'controllers/');
if(!defined('APP_MVC_VIEWS_PATH'))           define('APP_MVC_VIEWS_PATH', APP_PATH.'views/');
if(!defined('APP_MVC_FILTERS_PATH'))         define('APP_MVC_FILTERS_PATH', APP_PATH.'filters/');

if(!defined('URL_PARAM_NAME_CONTROLLER'))    define('URL_PARAM_NAME_CONTROLLER', 'c');
if(!defined('URL_PARAM_DEFAULT_CONTROLLER')) define('URL_PARAM_DEFAULT_CONTROLLER', 'home');
if(!defined('URL_PARAM_NAME_ACTION'))        define('URL_PARAM_NAME_ACTION', 'a');
if(!defined('URL_PARAM_DEFAULT_ACTION'))     define('URL_PARAM_DEFAULT_ACTION', 'index');

if(!defined('APP_MVC_USE_URL_REWRITE'))      define('APP_MVC_USE_URL_REWRITE', false);

?>
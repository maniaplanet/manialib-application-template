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
if (!defined('APP_PATH'))
	define('APP_PATH', dirname(__FILE__) . '/../'); 

if (!defined('APP_URL'))
	define('APP_URL', 'http://localhost/manialib/');
	
if (!defined('APP_FRAMEWORK_PATH'))
	define('APP_FRAMEWORK_PATH', APP_PATH.'manialib/' );
		
if (!defined('APP_FRAMEWORK_LIBRARIES_PATH'))
	define('APP_FRAMEWORK_LIBRARIES_PATH', APP_FRAMEWORK_PATH.'libraries/' );
	
if (!defined('APP_FRAMEWORK_GUI_TOOLKIT_PATH'))
	define('APP_FRAMEWORK_GUI_TOOLKIT_PATH', APP_FRAMEWORK_PATH.'gui-toolkit/' );
		
if (!defined('APP_LIBRARIES_PATH'))
	define('APP_LIBRARIES_PATH', APP_PATH.'libraries/' );
		
if (!defined('APP_LANGS_PATH'))
	define('APP_LANGS_PATH', APP_PATH.'langs/' );
		
if (!defined('APP_LOGS_PATH'))
	define('APP_LOGS_PATH', APP_PATH.'logs/' );
		
if (!defined('APP_INCLUDE_PATH'))
	define('APP_INCLUDE_PATH', APP_PATH.'include/' );
		
if (!defined('APP_CONFIG_PATH'))
	define('APP_CONFIG_PATH', APP_PATH.'config/');
		
if (!defined('APP_WWW_PATH'))
	define('APP_WWW_PATH', APP_PATH.'www/' );

if(!defined('APP_IMAGE_DIR_URL'))
	define('APP_IMAGE_DIR_URL', APP_URL.'images/');

if(!defined('APP_DATA_DIR_URL'))
	define('APP_IMAGE_DIR_URL', APP_URL.'data/');	

if (!defined('APP_ERROR_LOG'))
	define('APP_ERROR_LOG', APP_LOGS_PATH.'error.log' );
	
if (!defined('APP_DEBUG_LOG'))
	define('APP_DEBUG_LOG', APP_LOGS_PATH.'debug.log' );  
	
if (!defined('MANIALINK_NAME'))
	define('MANIALINK_NAME', 'manialib');

if (!defined('USE_SHORT_MANIALINKS'))
	define('USE_SHORT_MANIALINKS', false);

if (!defined('DEFAULT_TIMEZONE'))
	define('DEFAULT_TIMEZONE', 'Europe/Paris');

if (!defined('TIMEZONE_NAME'))
	define('TIMEZONE_NAME', 'GMT+1');

if (!defined('LANG_ENGINE_MODE'))
	define('LANG_ENGINE_MODE', 1);

if (!defined('DATABASE_HOST'))
	define('DATABASE_HOST', 'localhost');

if (!defined('DATABASE_USER'))
	define('DATABASE_USER', 'root');

if (!defined('DATABASE_PASSWORD'))
	define('DATABASE_PASSWORD', '');

if (!defined('DATABASE_NAME'))
	define('DATABASE_NAME', 'manialib');

if (!defined('DATABASE_PREFIX'))
	define('DATABASE_PREFIX', 'manialib_');

if (!defined('DEBUG_LEVEL'))
	define('DEBUG_LEVEL', 0); // 0 or 1

?>
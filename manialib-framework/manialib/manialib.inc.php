<?php
/**
 * Framework entry point
 * 
 * @author Maxime Raoust
 * @package Manialib
 */

ob_start();

// Framework includes. The classes will be loaded through the __autoload() function
require_once( dirname(__FILE__).'/config.default.php' );
require_once( dirname(__FILE__).'/settings.php' );
require_once( APP_FRAMEWORK_PATH.'utils.php' );
require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'Manialink.class.php' );
require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'standard.php' );
require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'styles.php' );

// Date config
date_default_timezone_set(DEFAULT_TIMEZONE);

// Error handler
error_reporting(E_ALL);
set_error_handler(array('ErrorHandling', 'manialinkHandler'));
set_exception_handler(array('ErrorHandling', 'exceptionHandler'));

?>
<?php
/**
 * App core entry point
 * 
 * @author Maxime Raoust
 * @package Manialib
 */

ob_start();

// Core includes. The classes will be loaded through the __autoload() function
require_once( dirname(__FILE__) . '/config.default.php' );
require_once( dirname(__FILE__) . '/settings.php' );
require_once( APP_CORE_PATH . 'utils.php' );

// Gui toolkit includes
require_once( APP_CORE_GUI_PATH . 'Manialink.class.php' );
require_once( APP_CORE_GUI_PATH . 'standard.php' );
require_once( APP_CORE_GUI_PATH . 'styles.php' );

// Date config
date_default_timezone_set(DEFAULT_TIMEZONE);

// Error handler
error_reporting(E_ALL);
set_error_handler(array('ErrorHandling', 'manialinkHandler'));
set_exception_handler(array('ErrorHandling', 'exceptionHandler'));

?>
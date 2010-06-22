<?php
/**
 * Include this file on every page to load the framework. Here you can instanciate
 * your objects and include your libraries.
 * @author Maxime Raoust
 */

require_once( dirname(__FILE__).'/config.php' );
require_once( dirname(__FILE__).'/manialib/manialib.inc.php' );

// Date config
date_default_timezone_set(APP_DEFAULT_TIMEZONE);

// Error handling
set_error_handler(array('ErrorHandling', 'exceptionErrorHandler'));
set_exception_handler(array('ErrorHandling', 'exceptionHandler'));

?>
<?php
/**
 * App core entry point
 * 
 * @author Maxime Raoust
 */


// Log teh start time for debug
$debugMtimeStart = microtime(true);

// Start the output buffer
ob_start(); 

// Core includes. The classes will be loaded through the __autoload() function
require_once( dirname(__FILE__) . "/../config.php" );
require_once( dirname(__FILE__) . "/config.default.php" );
require_once( dirname(__FILE__) . "/settings.php" );
require_once( APP_CORE_PATH . "utils.php" );
require_once( APP_CORE_PATH . "api/gui/inc.php" );

// Date config
date_default_timezone_set(DEFAULT_TIMEZONE);

// Error handler
error_reporting(E_ALL);
if(DEBUG_LEVEL < DEBUG_ON)
{
	set_error_handler("manialinkErrorHandler");
}
else
{
	set_error_handler("manialinkErrorHandlerDebug");
}

// Core objects init
$session = SessionEngine::getInstance();
$request = RequestEngine::getInstance();




?>
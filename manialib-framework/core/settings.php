<?php
/**
 * App settings
 * 
 * @author Maxime Raoust
 */

// Paths
define("APP_CORE_PATH", APP_PATH . "core/" );
define("APP_API_PATH", APP_CORE_PATH . "api/" );
define("APP_LIBRARIES_PATH", APP_PATH . "libraries/" );
define("APP_LANGS_PATH", APP_PATH . "langs/" );
define("APP_LOGS_PATH", APP_PATH . "logs/" );

// Logs
define("ERROR_LOG", APP_LOGS_PATH . "error.log" );
define("DEBUG_LOG", APP_LOGS_PATH . "debug.log" );  

// Debug
define("DEBUG_OFF", 0);
define("DEBUG_ON", 1);

// Lang engine modes
define("LANG_ENGINE_MODE_STATIC", 0);
define("LANG_ENGINE_MODE_DYNAMIC", 1);

?>
<?php
/**
 * Example config file. Rename to config.php !
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

// Put 1 to get verbose for error messages (for developement only !)
define('APP_DEBUG_LEVEL', 1);

// Default controller.
define('URL_PARAM_DEFAULT_CONTROLLER', 'home');

// URL of your manialink
define('APP_URL', 'http://localhost/manialib/');

// Name of your manialink
define('APP_MANIALINK', 'manialib');

// Mysql config
define('APP_DATABASE_HOST', '127.0.0.1');
define('APP_DATABASE_USER', 'root');
define('APP_DATABASE_PASS', '');
define('APP_DATABASE_NAME', 'manialib');

// Misc
define('APP_MVC_FRAMEWORK', true);
define('APP_PATH', dirname(__FILE__).'/../');

?>
<?php
/**
 * Example config file. Rename to config.php !
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

// URL of your Manialink
define('APP_URL', 'http://localhost/manialib/');

// "Short Manialink" of your Manialink
define('APP_MANIALINK', 'manialib');

// Default controller
define('APP_MVC_DEFAULT_CONTROLLER', 'Home');

// Debug level
// 1 for easy development
// 0 IF YOUR MANIALINK IS PUBLIC !
define('APP_DEBUG_LEVEL', 1);

// MySQL config
define('APP_DATABASE_HOST', 'localhost');
define('APP_DATABASE_USER', 'root');
define('APP_DATABASE_PASSWORD', '');
define('APP_DATABASE_NAME', 'ManiaLib');

// Application base paths.
// In most cases you shouldn't need to change that
define('APP_PATH', dirname(__FILE__).'/../');
define('APP_FRAMEWORK_PATH', APP_PATH.'manialib/');
define('APP_MVC_FRAMEWORK_PATH', APP_FRAMEWORK_PATH.'mvc/');

// ManiaHome favorite button config
define('APP_MANIAHOME_SHOW_BUTTON', true);
define('APP_MANIAHOME_NAME', '$oManiaLib');
define('APP_MANIAHOME_URL', APP_MANIALINK);
define('APP_MANIAHOME_PICTURE', null);

?>
<?php
/**
 * Example config file. Rename to config.php
 * Other overridable config constants can be found in manialib/config-default.
 * php
 * 
 * @author Maxime Raoust
 * @package Manialib
 */

/**
 * Local path of the application's directory. Leave as is if you don't know
 */
define('APP_PATH', dirname(__FILE__) . '/');

/**
 * URL of your manialink. For easy local access when developing, the short
 * manialink 'manialibdev' is definied and points to 
 * 'http://localhost/manialib/'.
 */
define('APP_URL', 'http://localhost/manialib/');

/**
 * URL of your manialink. For easy local access when developing, the short
 * manialink "manialibdev" is definied and points to 
 * "http://localhost/manialib/"".
 */
define('MANIALINK_NAME', 'manialibdev');

/**
 * If you use the short manialinks option, rename "use_short_manialinks.
 * htaccess" to .htaccess and check that Apache mod rewrite is enabled on your
 * server.
 */
define('USE_SHORT_MANIALINKS', false);

/**
 * Lang engine mode: if 0, the lang files will be included to be used as normal
 * Manialink dictionary files. If 1, the dynamic lang engine will be loaded and
 * translation strings will be obtained with the __() function
 */
define('LANG_ENGINE_MODE', 1);

/**#@+
 * Database config
 */
define('DATABASE_HOST', 'localhost');
define('DATABASE_USER', 'root');
define('DATABASE_PASSWORD', '');
define('DATABASE_NAME', 'manialib');
/**#@-*/
?>
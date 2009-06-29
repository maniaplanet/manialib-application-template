<?php
/**
 * Config file
 * 
 * @author Maxime Raoust
 */

// All those default values can be overridden in config.php

if (!defined("APP_PATH"))
	define("APP_PATH", dirname(__FILE__) . "/../"); // This doesn't work well with USE_SHORT_MANIALINK set to true

if (!defined("APP_URL"))
	define("APP_URL", "http://localhost/manialib/");

if (!defined("MANIALINK_NAME"))
	define("MANIALINK_NAME", "manialib");

if (!defined("USE_SHORT_MANIALINKS"))
	define("USE_SHORT_MANIALINKS", false);

if (!defined("DEFAULT_TIMEZONE"))
	define("DEFAULT_TIMEZONE", "Europe/Paris");

if (!defined("DATABASE_HOST"))
	define("DATABASE_HOST", "localhost");

if (!defined("DATABASE_USER"))
	define("DATABASE_USER", "root");

if (!defined("DATABASE_PASSWORD"))
	define("DATABASE_PASSWORD", "");

if (!defined("DATABASE_NAME"))
	define("DATABASE_NAME", "manialib");

if (!defined("DATABASE_PREFIX"))
	define("DATABASE_PREFIX", "manialib_");

if (!defined("DEBUG_LEVEL"))
	define("DEBUG_LEVEL", 0); // 0 or 1
?>
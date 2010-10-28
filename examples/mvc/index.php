<?php
/**
 * Application entry point
 * 
 * It should only require the config, the frameworks and the bootstrapp 
 * to allow easy updates of the bootstrapper
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

define('APP_MVC_FRAMEWORK', true);

// Load config
require_once(dirname(__FILE__).'/config/config.php');

// Bootstrapper: actually do the MVC magic
require_once(APP_MVC_FRAMEWORK_PATH.'bootstrapper.inc.php');

?>
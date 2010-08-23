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

// Load config
require_once(dirname(__FILE__).'/config/config.php');

// Load framework
require_once(dirname(__FILE__).'/manialib/manialib.inc.php');
require_once(dirname(__FILE__).'/manialib/mvc/mvc.inc.php');

// Bootstrapper: actually do the MVC magic
require_once(APP_MVC_FRAMEWORK_PATH.'bootstrapper.inc.php');

?>
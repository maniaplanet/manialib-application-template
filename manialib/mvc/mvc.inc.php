<?php
/**
 * MVC framework entry point
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib_MVC
 */

/**#@+
 * @ignore
 */
require_once(dirname(__FILE__).'/config.default.php');
require_once(APP_MVC_FRAMEWORK_PATH.'utils.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'ActionController.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'Filterable.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'AdvancedFilter.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'ResponseEngine.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'View.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'Route.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'RequestEngineMVC.class.php');
/**#@-*/

?>
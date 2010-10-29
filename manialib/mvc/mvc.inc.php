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

AutoloadHelper::$paths[] = APP_MVC_CONTROLLERS_PATH;
AutoloadHelper::$paths[] = APP_MVC_FILTERS_PATH;
AutoloadHelper::$paths[] = APP_MVC_MODELS_PATH;
AutoloadHelper::$paths[] = APP_MVC_FRAMEWORK_FILTERS_PATH;
AutoloadHelper::$paths[] = APP_MVC_FRAMEWORK_LIBRARIES_PATH;

require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'MVCException.class.php'); 
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'ActionController.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'Filterable.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'AdvancedFilter.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'ResponseEngine.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'View.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'Route.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'RequestEngineMVC.class.php');
/**#@-*/

?>
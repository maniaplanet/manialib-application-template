<?php
/**
 * MVC Framework loading
 */

require_once(dirname(__FILE__).'/config.default.php');
require_once(APP_MVC_FRAMEWORK_PATH.'utils.php');

require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'ActionController.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'Filterable.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'AdvancedFilter.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'ResponseEngine.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'View.class.php');
require_once(APP_MVC_FRAMEWORK_LIBRARIES_PATH.'RequestEngineMVC.class.php');

?>
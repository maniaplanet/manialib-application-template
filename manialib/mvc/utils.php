<?php 
/**
 * MVC framework functions
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib_MVC
 */

AutoloadHelper::$paths[] = APP_MVC_CONTROLLERS_PATH;
AutoloadHelper::$paths[] = APP_MVC_FILTERS_PATH;
AutoloadHelper::$paths[] = APP_MVC_MODELS_PATH;
AutoloadHelper::$paths[] = APP_MVC_FRAMEWORK_FILTERS_PATH;
AutoloadHelper::$paths[] = APP_MVC_FRAMEWORK_LIBRARIES_PATH;
AutoloadHelper::$paths[] = APP_MVC_FRAMEWORK_EXCEPTIONS_PATH;

?>
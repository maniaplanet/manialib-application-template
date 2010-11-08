<?php
/**
 * Framework entry point
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * ManiaLib version
 * @ignore
 */
define('MANIALIB_VERSION', '1.0b1');

/** 
 * Autoload helper
 * @package ManiaLib
 * @ignore
 */ 
abstract class AutoloadHelper
{
	static $paths = array();
}

/**
 * Class autoloader
 * @param string Class to load
 * @ignore
 */
function __autoload($className)
{
	foreach(AutoloadHelper::$paths as $path)
	{
		if(file_exists($path = $path.$className.'.class.php'))
		{
			require_once($path);
			return true;
		}
	}
	return false;
}

/**#@+
 * @ignore
 */
require_once( dirname(__FILE__).'/config.default.php' );
require_once( dirname(__FILE__).'/settings.php' );

AutoloadHelper::$paths[] = APP_LIBRARIES_PATH;
AutoloadHelper::$paths[] = APP_FRAMEWORK_LIBRARIES_PATH;
AutoloadHelper::$paths[] = APP_FRAMEWORK_GUI_TOOLKIT_PATH.'cards/';
AutoloadHelper::$paths[] = APP_FRAMEWORK_GUI_TOOLKIT_PATH.'layouts/';

require_once( APP_FRAMEWORK_LIBRARIES_PATH.'ErrorHandling.class.php' );
require_once( APP_FRAMEWORK_LIBRARIES_PATH.'RequestEngine.class.php' );
require_once( APP_FRAMEWORK_LIBRARIES_PATH.'SessionEngine.class.php' );
require_once( APP_FRAMEWORK_LIBRARIES_PATH.'LangEngine.class.php' );
require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'Manialink.class.php' );
require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'Maniacode.class.php' );
/**#@-*/

?>
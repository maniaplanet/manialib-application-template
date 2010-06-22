<?php 
/**
 * MVC framework utilities
 */

function autoload_mvc_framework($className)
{
	if(file_exists($path = APP_MVC_FRAMEWORK_EXCEPTIONS_PATH.$className.'.class.php'))
	{
		require_once($path);
		return true;
	}
	return false;
}

?>
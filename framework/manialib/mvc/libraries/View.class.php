<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib_MVC
 */

/**
 * View rendering stuff
 * @package ManiaLib_MVC
 */
abstract class View
{
	public static function render($controllerName, $actionName=null)
	{
		$viewFilename = self::getFilename($controllerName,$actionName);
		if(!file_exists($viewFilename))
		{
			throw new ViewNotFoundException($viewFilename);
		}
		$response = ResponseEngine::getInstance();
		$request = RequestEngineMVC::getInstance();
		ob_start();
		require($viewFilename);
		$response->appendBody(ob_get_contents());
		ob_end_clean();
	}
	
	public static function getFilename($controllerName, $actionName=null)
	{
		if($controllerName && $actionName)
		{
			return APP_MVC_VIEWS_PATH.$controllerName.'/'.$actionName.'.php';
		}
		else
		{
			return APP_MVC_VIEWS_PATH.$controllerName.'.php';
		}
	}
}

/**
 * @package ManiaLib_MVC
 */
class ViewNotFoundException extends MVCException {}

?>
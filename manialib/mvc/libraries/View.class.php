<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 * @subpackage MVC
 */

/**
 * View rendering features
 * @package ManiaLib
 * @subpackage MVC
 */
abstract class View
{
	/**
	 * Renders a view
	 * You can use this method from within a view to render another view.
	 * Usefull for things like rendering a navigation menu on every page.
	 * 
	 * Examples:
	 * <code>
	 * View::render('header'); // Renders /views/header.php
	 * View::render('Home', '_navigation'); // Renders /views/Home/_navigation.php
	 * </code>
	 */
	public static function render($controllerName, $actionName=null)
	{
		$viewFilename = self::getFilename($controllerName,$actionName);
		if(!file_exists($viewFilename))
		{
			$viewFilename = self::getFilename($controllerName, $actionName, 
				APP_MVC_FRAMEWORK_VIEWS_PATH);
			if(!file_exists($viewFilename))
			{
				throw new ViewNotFoundException($controllerName.'::'.$actionName);
			}
		}
		$response = ResponseEngine::getInstance();
		$request = RequestEngineMVC::getInstance();
		ob_start();
		require($viewFilename);
		$response->appendBody(ob_get_contents());
		ob_end_clean();
	}
	
	/**
	 * @ignore
	 */
	public static function getFilename($controllerName, $actionName=null, $path=APP_MVC_VIEWS_PATH)
	{
		if($controllerName && $actionName)
		{
			return $path.$controllerName.'/'.$actionName.'.php';
		}
		else
		{
			return $path.$controllerName.'.php';
		}
	}
}

/**
 * @package ManiaLib
 * @subpackage MVC
 * @ignore
 */
class ViewNotFoundException extends MVCException {}

?>
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
abstract class ManiaLib_Application_View
{
	/**
	 * @var ManiaLib_Application_Request
	 */
	protected $request;
	/**
	 * @var ManiaLib_Application_Response
	 */
	protected $response;
	protected $controllerName;
	protected $actionName;
	
	static function renderExternal($controllerName, $actionName)
	{
		if($actionName)
		{
			$viewClass = $controllerName.NAMESPACE_SEPARATOR.ucfirst($actionName);
		}
		else
		{
			$viewClass = $controllerName;
		}
		if(!class_exists($viewClass))
		{
			throw new ManiaLib_Application_ViewNotFoundException($viewClass);
		}
		$view = new $viewClass($controllerName, $actionName);
		$view->display();
	}
	
	final protected function __construct($controllerName, $actionName)
	{
		$this->request = ManiaLib_Application_Request::getInstance();
		$this->response = ManiaLib_Application_Response::getInstance();
		
		$this->controllerName = $controllerName;
		$this->actionName = $actionName;
		
		$this->onConstruct();
	}

	final protected function renderSubView($viewName)
	{
		self::renderExternal($this->controllerName, $viewName);
	}
	
	protected function onConstruct() {}
	
	abstract function display();
}

/**
 * @package ManiaLib
 * @subpackage MVC
 * @ignore
 */
class ManiaLib_Application_ViewNotFoundException extends Exception {}

?>
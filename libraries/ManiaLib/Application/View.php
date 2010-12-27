<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * View features
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
	
	static function render($viewClass)
	{
		if(!class_exists($viewClass))
		{
			throw new ManiaLib_Application_ViewNotFoundException($viewClass);
		}
		$view = new $viewClass();
		$view->display();
		
		if($view instanceof ManiaLib_Application_Views_Dialogs_DialogInterface)
		{
			ManiaLib_Gui_Manialink::disableLinks();
		}
	}
	
	final protected function __construct()
	{
		$this->request = ManiaLib_Application_Request::getInstance();
		$this->response = ManiaLib_Application_Response::getInstance();
		$this->onConstruct();
	}

	final protected function renderSubView($viewName)
	{
		$className = get_class($this);
		$className = explode(NAMESPACE_SEPARATOR, $className);
		array_pop($className);
		array_push($className, ucfirst($viewName));
		$className = implode(NAMESPACE_SEPARATOR, $className);
		self::render($className);
	}
	
	protected function onConstruct() {}
	
	abstract function display();
}

class ManiaLib_Application_ViewNotFoundException extends Exception {}

?>
<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib_MVC
 */

/**
 * RequestEngine designed for MVC framework
 * @package ManiaLib_MVC
 */
class RequestEngineMVC extends RequestEngine
{
	static private $instance;
	
	/**
	 * Gets the instance
	 * @return RequestEngineMVC
	 */
	public static function getInstance()
	{
		if (!self::$instance)
		{
			$class = __CLASS__;
			self::$instance = new $class;
		}
		return self::$instance;
	}
	
	public function getAction($defaultAction = null)
	{
		return strtolower($this->get(URL_PARAM_NAME_ACTION, $defaultAction));		
	}
	
	public function setAction($actionName)
	{
		$this->set(URL_PARAM_NAME_ACTION, $actionName);
	}
	
	public function getController()
	{
		return strtolower($this->get(URL_PARAM_NAME_CONTROLLER, URL_PARAM_DEFAULT_CONTROLLER));
	}
	
	public function setController($controllerName)
	{
		$this->set(URL_PARAM_NAME_CONTROLLER, $controllerName);
	}
	
	/**
	 * Redirects to the specified route with all defined GET vars in the URL
	 * @param string Can be the name of a controller or a class const of Route
	 * @param string Can be the name of an action or a class const of Route 
	 */
	public function redirectManialink($controller = Route::CUR, $action = Route::CUR)
	{
		$manialink = $this->createLink($controller, $action);
		$this->redirectManialinkAbsolute($manialink);
	}
	
	/**
	 * Redirects to the specified route with, with names of GET vars as parameters of the method
	 * @param string Can be the name of a controller or a class const of Route
	 * @param string Can be the name of an action or a class const of Route 
	 */
	public function redirectManialinkArgList($controller, $action)
	{
		$arr = func_get_args();
		array_shift($arr);
		$args = array();
		foreach($arr as $elt)
		{
			if(array_key_exists($elt, $this->params))
			{
				$args[$elt] = $this->params[$elt];
			}	
		}
		$manialink = $this->createLinkString($controller, $action, $args);
		$this->redirectManialinkAbsolute($manialink);
	}
	
	/**
	 * Creates a link to the specified route with all defined GET vars in the URL
	 * @param string Can be the name of a controller or a class const of Route
	 * @param string Can be the name of an action or a class const of Route 
	 */
	public function createLink($controller = Route::CUR, $action = Route::CUR)
	{
		return $this->createLinkString($controller, $action, $this->params);
	}
	
	/**
	 * Creates a link to the specified route with, with names of GET vars as parameters of the method
	 * @param string Can be the name of a controller or a class const of Route
	 * @param string Can be the name of an action or a class const of Route 
	 */
	function createLinkArgList($controller = Route::CUR, $action = Route::CUR)
	{
		$arr = func_get_args();
		array_shift($arr);
		$args = array();
		foreach($arr as $elt)
		{
			if(array_key_exists($elt, $this->params))
			{
				$args[$elt] = $this->params[$elt];
			}	
		}
		return $this->createLinkString($controller, $action, $args);
	}
	
	protected function createLinkString($controller = Route::CUR, $action = Route::CUR, $params)
	{
		switch($controller)
		{
			case Route::CUR:
			case null:
				$controller = $this->getController();
				break;
				
			case Route::DEF:
				$controller = URL_PARAM_DEFAULT_CONTROLLER;
				break;
				
			case Route::NONE:
				$controller = null;
				break;
				
			default:
				// Nothing here
		}
		
		switch($action)
		{
			case Route::CUR:
			case null:
				 $action = $this->getAction(null);
				 break;
				 
			case Route::DEF:
			case Route::NONE:
				$action = null;
				break;
				
			default:
				// Nothing here
		}
		
		unset($params[URL_PARAM_NAME_CONTROLLER]);
		unset($params[URL_PARAM_NAME_ACTION]);
		
		if(APP_MVC_USE_URL_REWRITE)
		{
			$url = APP_URL.$controller.'/';
			if($action)
			{
				$url .= $action.'/';
			}
		}
		else
		{
			$url = APP_URL;
			if($action)
			{
				$params = array_merge(
					array(
						URL_PARAM_NAME_CONTROLLER => $controller,
						URL_PARAM_NAME_ACTION => $action),
					$params);
			}
			else
			{
				$params = array_merge(
					array(
						URL_PARAM_NAME_CONTROLLER => $controller),
					$params);
			}
		}
		
		// Create parameter string
		if(count($params))
		{
			if(!APP_HPHP_COMPILE)
			{
				$params = '?'.(defined('SID') && SID ? SID.'&' : '').http_build_query($params, '', '&');
			}
			else
			{
				// TODO Fix this when HPHP supports "defined('SID')"
				$params = '?'.http_build_query($params, '', '&');  
			}
		}
		else
		{
			$params = '';
		}
				
		return $url.$params;
	}
}

?>
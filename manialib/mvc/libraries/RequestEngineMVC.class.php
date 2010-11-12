<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 * @subpackage MVC
 */

/**
 * RequestEngine designed for MVC framework
 * @package ManiaLib
 * @subpackage MVC
 */
class RequestEngineMVC extends RequestEngine
{
	/**
	 * @ignore 
	 */
	static private $instance;
	
	/**#@+
	 * @ignore 
	 */
	protected $action;
	protected $controller;
	/**#@-*/
	
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
	
	/**
	 * @ignore 
	 */
	protected function __construct()
	{
		parent::__construct();
		$route = array_keys($this->params);
		$route = reset($route);
		if($route && substr($route, 0, 1)=='/')
		{
			array_shift($this->params);
			$route = explode('/', $route);
		}
		else 
		{
			$route = array();
		}
		// $route[0] is null because of the first '/'
		$this->controller = array_key_exists(1, $route) && $route[1] ? $route[1] : APP_MVC_DEFAULT_CONTROLLER;
		$this->action = array_key_exists(2, $route) && $route[2] ? $route[2] : null;
		$this->controller = Route::separatorToUpperCamelCase($this->controller);
		$this->action = $this->action ? Route::separatorToCamelCase($this->action) : null;
	}
	
	public function getAction($defaultAction = null)
	{
		return $this->action ? $this->action : $defaultAction;
	}
		
	public function getController()
	{
		return $this->controller;
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
	
	/**
	 * @ignore 
	 */
	protected function createLinkString($controller = Route::CUR, $action = Route::CUR, $params = array())
	{
		switch($controller)
		{
			case Route::CUR:
			case null:
				$controller = $this->getController();
				break;
				
			case Route::DEF:
				$controller = APP_MVC_DEFAULT_CONTROLLER;
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
		$controller = Route::camelCaseToSeparator($controller);
		$action = Route::camelCaseToSeparator($action);
		
		// URL string
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
			$route = '';
			if($controller)
			{
				$route = '/'.$controller.'/';
				if($action)
				{
					$route .= $action.'/';
				}
			}
			if($route)
			{
				$url = $url.'?'.$route;
			}
		}
		// Create parameter string
		if(count($params))
		{
			$params = http_build_query($params, '', '&');
		}
		else
		{
			$params = '';
		}
		if(APP_MVC_USE_URL_REWRITE)
		{
			return $url.($params? '?'.$params:'');
		}	
		else
		{
			return $url.($params? ($route?'&':'?').$params : '');
		}
		
	}
}

?>
<?php
/**
 * RequestEngine designed for MVC framework
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
	
	public function getAction($defaultAction = URL_PARAM_DEFAULT_ACTION)
	{
		return strtolower($this->get(URL_PARAM_NAME_ACTION, $defaultAction));		
	}
	
	public function getController()
	{
		return strtolower($this->get(URL_PARAM_NAME_CONTROLLER, URL_PARAM_DEFAULT_CONTROLLER));
	} 

	public function redirectManialink($controller=null, $action=null)
	{
		$manialink = $this->createLink($controller, $action);
		$this->redirectManialinkAbsolute($manialink);
	}
	
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
	
	public function createLink($controller=null, $action=null)
	{
		return $this->createLinkString($controller, $action, $this->params);
	}
	
	function createLinkArgList($controller=null, $action=null)
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
	
	protected function createLinkString($controller=null, $action=null, $params)
	{
		$controller = $controller ? $controller : $this->getController();
		$action = $action ? $action : $this->getAction(null);
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
			$params = array_merge(
				array(
					URL_PARAM_NAME_CONTROLLER => $controller,
					URL_PARAM_NAME_ACTION => $action),
				$params);
		}
		
		// Create parameter string
		if(count($params))
		{
			$params = '?'.(defined('SID') && SID ? SID.'&' : '').http_build_query($params, '', '&'); 
		}
		else
		{
			$params = '';
		}
				
		return $url.$params;
	}
}

?>
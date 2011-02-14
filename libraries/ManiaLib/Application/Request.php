<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\Application;

/**
 * Manages http request: retrieve params, create links and redirections
 */
class Request
{
	/**
	 * @ignore 
	 */
	static private $instance;
	
	protected $requestParams = array();
	protected $params = array();
	protected $protectedParams = array();
	protected $globalParams = array();
	protected $URLBase;
	protected $URLPath;
	protected $URLFile;
	protected $registerRefererAtDestruct;
	protected $appURL;

	protected $action;
	protected $controller;
	protected $defaultController;
	
	protected $sessionEnabled;
	
	/**
	 * Gets the instance
	 * @return \ManiaLib\Application\Request
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
		// TODO This is a hack because of a bug on the master server and may cause some trouble!
		foreach ($_GET as $key => $value)
			$this->params[str_replace('amp;', '', $key)] = $value;
		
		if(get_magic_quotes_gpc())
		{
			$this->params = array_map('stripslashes', $this->params);
		}
		$this->requestParams = $this->params;
		$this->appURL = Config::getInstance()->URL;
		
		$this->defaultController = Config::getInstance()->defaultController;
		$route = \ManiaLib\Utils\Arrays::getNotNull($_SERVER, 'PATH_INFO', '/');
		$route = substr($route, 1); // Remove starting /
		$route = explode('/', $route);
		$this->controller = \ManiaLib\Utils\Arrays::getNotNull($route, 0, $this->defaultController);
		$this->action = \ManiaLib\Utils\Arrays::get($route, 1);
		$this->controller = \ManiaLib\Application\Route::separatorToUpperCamelCase($this->controller);
		$this->action = $this->action ? \ManiaLib\Application\Route::separatorToCamelCase($this->action) : null;
		
		$this->sessionEnabled = \ManiaLib\Session\Config::getInstance()->enabled;
	}
	
	function __destruct()
	{
		if($this->registerRefererAtDestruct && $this->sessionEnabled)
		{
			$session = \ManiaLib\Session\Session::getInstance();
			$session->set('referer', rawurlencode($this->registerRefererAtDestruct));
		}
	}
	
	/**
	 * Retrieves a GET parameter, or the default value if not found
	 * @param string
	 * @param mixed
	 * @return mixed
	 */
	function get($name, $default=null)
	{
		if(array_key_exists($name, $this->params))
		{
			return $this->params[$name];
		}	
		else
		{
			return $default;
		}	
	}
	
	/**
	 * Retrieves a GET parameter, or throws an exception if not found or null
	 * @param string
	 * @param string Optional human readable name for error dialog
	 * @return mixed
	 */
	function getStrict($name, $message=null)
	{
		if(array_key_exists($name, $this->params) && $this->params[$name])
		{
			return $this->params[$name];
		}
		elseif($message)
		{
			throw new \ManiaLib\Application\UserException($message);
		}
		else
		{
			throw new \InvalidArgumentException($name);	
		}
	}
	
	/**
	 * Sets a GET parameter
	 * 
	 * @param string
	 * @param mixed
	 */
	function set($name, $value)
	{
		$this->params[$name] = $value;
	}
	
	/**
	 * Deletes a GET parameter
	 * 
	 * @param string
	 */
	function delete($name)
	{
		unset($this->params[$name]);
	}
	
	/**
	 * Restores a GET parameter to the value it had when the page was loaded
	 * 
	 * @param string
	 */
	function restore($name)
	{
		if(array_key_exists($name, $this->requestParams))
		{
			$this->params[$name] = $this->requestParams[$name];
		}
		else
		{
			$this->delete($name);
		}
	}
	
	public function getAction($defaultAction = null)
	{
		return $this->action ? $this->action : $defaultAction;
	}
		
	public function getController()
	{
		return $this->controller;
	}
	
	public function isAction($action, $defaultAction = null)
	{
		return (strcasecmp($this->getAction($defaultAction), $action) == 0);
	}
	
	/**
	 * Registers the current page as referer
	 */
	function registerReferer()
	{
		if($this->sessionEnabled)
		{
			$session = \ManiaLib\Session\Session::getInstance();
			$link = $this->createLink();
			$this->registerRefererAtDestruct = $link;
		}
	}
	
	/**
	 * Returns the referer, or the specified default page, or index.php
	 * @param string
	 */
	function getReferer($default=null)
	{
		$referer = null;
		if($this->sessionEnabled)
		{
			$session = \ManiaLib\Session\Session::getInstance();
			$referer = $session->get('referer');
		}
		if($referer)
		{
			return rawurldecode($referer);
		}
		elseif($default)
		{
			return $default;
		}
		else
		{
			return $this->appURL;
		}
	}
	
	/**
	 * Registers the '$name' parameter as protected parameters. Protected
	 * parameters are always removed from the parameter array when the page is
	 * loaded.
	 * @param string
	 */
	function registerProtectedParam($name)
	{
		$this->protectedParams[] = $name;
		unset($this->params[$name]);
	}
	
	/**
	 * Registers the "$name" parameter as protected parameters. Global
	 * parameters atr always removed from the parameter array and saved as a
	 * session parameter when the page is loaded.
	 * @param string
	 */
	function registerGlobalParam($name)
	{
		if(array_key_exists($name,$this->requestParams))
		{
			$value = $this->requestParams[$name];
			if($value !== null)
			{
				$session = \ManiaLib\Session\Session::getInstance();
				$session->set($name, $value);
				$this->registerProtectedParam($name);
			}
		}
	}
	
	/**
	 * Redirects to the specified route with all defined GET vars in the URL
	 * @param string Can be the name of a controller or a class const of Route
	 * @param string Can be the name of an action or a class const of Route 
	 */
	public function redirectManialink($controller = \ManiaLib\Application\Route::CUR, $action = \ManiaLib\Application\Route::CUR)
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
	 * Creates a Manialink redirection to the specified absolute URI
	 * 
	 * @param string
	 */
	function redirectManialinkAbsolute($absoluteUri)
	{
		\ManiaLib\Gui\Manialink::redirect($absoluteUri);
	}
	
	/**
	 * Creates a Manialink redirection to the previously registered referer, or
	 * the index if no referer was previously registered
	 */
	function redirectToReferer()
	{
		\ManiaLib\Gui\Manialink::redirect($this->getReferer());
	}
	
	/**
	 * Creates a link to the specified route with all defined GET vars in the URL
	 * @param string Can be the name of a controller or a class const of Route
	 * @param string Can be the name of an action or a class const of Route 
	 */
	public function createLink($controller = \ManiaLib\Application\Route::CUR, $action = \ManiaLib\Application\Route::CUR)
	{
		return $this->createLinkString($controller, $action, $this->params);
	}
	
	/**
	 * Creates a link to the specified route with, with names of GET vars as parameters of the method
	 * @param string Can be the name of a controller or a class const of Route
	 * @param string Can be the name of an action or a class const of Route 
	 */
	function createLinkArgList($controller = \ManiaLib\Application\Route::CUR, $action = \ManiaLib\Application\Route::CUR)
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
	 * Returns an URL with the request parameters specified as method arguments
	 * 
	 * @param string The absolute URL
	 * @return string
	 * @deprecated Old code, not sure if it is still used?
	 */
	function createAbsoluteLinkArgList($absoluteLink)
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
		return $absoluteLink.($args ? '?'.http_build_query($args) : '');
	}
	
	/**
	 * @ignore 
	 */
	protected function createLinkString($controller = \ManiaLib\Application\Route::CUR, $action = \ManiaLib\Application\Route::CUR, $params = array())
	{
		switch($controller)
		{
			case \ManiaLib\Application\Route::CUR:
			case null:
				$controller = $this->getController();
				break;
				
			case \ManiaLib\Application\Route::DEF:
				$controller = $this->defaultController;
				break;
				
			case \ManiaLib\Application\Route::NONE:
				$controller = null;
				break;
				
			default:
				// Nothing here
		}
		
		switch($action)
		{
			case \ManiaLib\Application\Route::CUR:
			case null:
				 $action = $this->getAction(null);
				 break;
				 
			case \ManiaLib\Application\Route::DEF:
			case \ManiaLib\Application\Route::NONE:
				$action = null;
				break;
				
			default:
				// Nothing here
		}
		$controller = \ManiaLib\Application\Route::camelCaseToSeparator($controller);
		$action = \ManiaLib\Application\Route::camelCaseToSeparator($action);
		
		$route = '';
		if($controller)
		{
			$route .= $controller.'/';
			if($action)
			{
				$route .= $action.'/';
			}
		}
		
		if(Config::getInstance()->useRewriteRules)
		{
			$url = $this->appURL.$route;
		}
		else 
		{
			$route = $route ? '/'.$route : '';
			$url = $this->appURL.'index.php'.$route;
		}
		
		if(count($params))
		{
			$queryString = '?'.http_build_query($params, '', '&');
		}
		else
		{
			$queryString = '';
		}
		
		return $url.$queryString;
	}
}

?>
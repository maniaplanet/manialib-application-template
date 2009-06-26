<?php
/**
 * Request handler
 * 
 * @author Maxime Raoust
 */

final class RequestEngine
{
	private static $instance;
	
	private $requestParams = array();
	private $params = array();
	private $protectedParams = array();
	private $globalParams = array();
	
	private $registerRefererAtDestruct;
	
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
	 * Retrieves a request parameter
	 */
	function get($name, $default=null)
	{
		if(isset($this->params[$name]))
			return $this->params[$name];
		else
			return $default;
	}
		
	/**
	 * Sets a request parameter
	 */
	function set($name, $value)
	{
		$this->params[$name] = $value;
	}
	
	/**
	 * Deletes a request parameter
	 */
	function delete($name)
	{
		unset($this->params[$name]);
	}
	
	/**
	 * Restore a request parameter to the value it had when the page was loaded
	 */
	function restore($name)
	{
		if(isset($this->requestParams[$name]))
		{
			$this->params[$name] = $this->requestParams[$name];
		}
	}
	
	/**
	 * Returns an url with all the currently defined request parameters
	 */
	function createLink($file=null, $relativePath=true)
	{
		$arr = $this->params;
		return $this->createLinkString($file, true, $arr);
	}
	
	/**
	 * Returns an url with the request parameters specified as method arguments
	 * (eg. createLinkArgList("index.php", "id", "page") )
	 */
	function createLinkArgList($file=null)
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
		return $this->createLinkString($file, true, $args);
	}
	
	/**
	 * Creates a Manialink redirection to the specified file with request
	 * parameters specified as method arguments
	 */
	function redirectManialink($file="index.php")
	{
		ob_clean();
		$arr = func_get_args();
		array_shift($arr);
		array_unshift($arr, $file);
		$link = call_user_func_array(array($this,  "createLinkArgList"), $arr);
		header("Content-Type: text/xml; charset=utf-8");
		echo("<redirect>$link</redirect>");
		exit;
	}
	
	/**
	 * Creates a Manialink redirection to the specified URI
	 */
	function redirectManialinkAbsolute($absoluteUri)
	{
		ob_clean();
		echo("<redirect>$absoluteUri</redirect>");
		exit;
	}
	
	/**
	 * Creates a Manialink redirection to the previously saved referer
	 */
	function redirectToReferer()
	{
		ob_clean();
		$link = $this->getReferer();
		echo("<redirect>$link</redirect>");
		exit;
	}
	
	/**
	 * Protected request parameters will always be deleted from the list
	 */
	function registerProtectedParam($name)
	{
		$this->protectedParams[] = $name;
		unset($this->params[$name]);
	}
	
	/**
	 * Global request parameters will always be saved in the session and then
	 * deleted from the list
	 */
	function registerGlobalParam($name)
	{
		$value = array_get($this->requestParams, $name, null);
		if($value !== null)
		{
			$session = SessionEngine::getInstance();
			$session->set($name, $value);
			$this->registerProtectedParam($name);
		}
	}
	
	/**
	 * Registers the current page as referer
	 */
	function registerReferer()
	{
		$session = SessionEngine::getInstance();
		$link = $this->createLink();
		$this->registerRefererAtDestruct = $link;
	}
	
	/**
	 * Returns the  referer, or the specified default page, or index.php
	 */
	function getReferer($default=null)
	{
		$session = SessionEngine::getInstance();
		$referer = $session->get("referer");
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
			return APP_URL."index.php";
		}
	}
	
	function __destruct()
	{
		if($this->registerRefererAtDestruct)
		{
			$session = SessionEngine::getInstance();
			$session->set("referer", rawurlencode($this->registerRefererAtDestruct));
		}
	}

	private function __construct()
	{
		$this->params = $_GET;
		$this->requestParams = $_GET;
	}
	
	private function createLinkString($file=null, $relativePath=true, $params)
	{
		// Baseurl
		$link = "";
		if($file==null)
		{
			$file = basename($_SERVER["SCRIPT_FILENAME"]);
		}
		if($relativePath)
		{
			$link = explode("/", strtolower($_SERVER["SERVER_PROTOCOL"]));
			$link = (string) reset($link);
			$link .= ((isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on') ? "s" : "");
			$link .= "://";
			$link .= $_SERVER['SERVER_NAME'];
			if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS']=='on')
			{
				if($_SERVER['SERVER_PORT']!='443') $link .= ":".$_SERVER['SERVER_PORT'];
			}
			elseif($_SERVER['SERVER_PORT']!='80')
			{
				$link .= ":".$_SERVER['SERVER_PORT'];
			}
			$link .= dirname($_SERVER['SCRIPT_NAME']);
			$link .= "/";	
		}
		$link .= $file;
		
		// Params
		foreach($params as $name=>$value)
		{

			$params[$name] = "$name=$value";
		}	
		
		// SID
		if(SID) 
		{
			$link .= "?".htmlspecialchars(SID);
		}
		
		// Return if no params
		if(count($params)==0)
		{
			return $link;
		}
		
		// Create the output	
		$params = implode("&amp;", $params);
		if(SID)
		{
			$link .= "&amp;";
		}
		else
		{
			$link .= "?";	
		}
		$link .= $params;
			
		// Return the output
		return $link;
	}
	
}
?>
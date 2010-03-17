<?php
/**
 * @author Maxime Raoust
 * @package Manialib
 */

// TODO RequestEngine debug: short manialinks
// TODO RequestEngine debug: sub-directories
// TODO RequestEngine debug: absolute URLs

/**
 * <b>Request engine</b>: used to handle GET parameters and to create hyperlink
 * strings and redirections
 */
final class RequestEngine
{
	private static $instance;
	
	private $requestParams = array();
	private $params = array();
	private $protectedParams = array();
	private $globalParams = array();
	
	private $URLBase;
	private $URLPath;
	private $URLFile;
	
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
		{
			return $this->params[$name];
		}	
		else
		{
			return $default;
		}	
	}
	
	/**
	 * Retrieves a request parameter and throws an exception if not found
	 */
	function getStrict($name)
	{
		if(isset($this->params[$name]))
		{
			return $this->params[$name];
		}	
		throw new ManialinkException('Parameter "'.$name.'" not set');
	}
		
	/**
	 * Sets a request parameter
	 */
	function set($name, $value)
	{
		if($name=='rp')
		{
			throw new ManialinkException('You cannot use "rp" as a request parameter');
		}
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
		else
		{
			$this->delete($name);
		}
	}
	
	/**
	 * Returns an url with all the currently defined request parameters
	 */
	function createLink($file=null, $relativePath=true)
	{
		$arr = $this->params;
		return $this->createLinkString($file, $relativePath, $arr);
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
		if(get_magic_quotes_gpc())
		{
			$this->params = array_filter($this->params, 'stripslashes');
		}
		$this->requestParams = $this->params;
		$this->registerProtectedParam("rp");
	}
	
	private function createLinkString($file=null, $relativePath=true, $params)
	{
		// If absolute path, there's nothing to do
		if(!$relativePath)
		{
			$link = $file;
		}
		
		// If relative path, we have to compute the link
		else
		{
			// URL base
			if($this->URLBase === null)
			{
				$this->URLBase = USE_SHORT_MANIALINKS ? MANIALINK_NAME : APP_URL;
			}
			
			// URL path
			if($this->URLPath === null)
			{
				if(APP_URL_PATH)
				{
					$this->URLPath = dirname(str_ireplace(
						str_replace('\\', '/', APP_URL_PATH),
						'',
						str_replace('\\', '/', $_SERVER['REQUEST_URI'])
					));
				}
				else
				{
					$this->URLPath = dirname(
						str_replace('\\', '/', $_SERVER['REQUEST_URI']));
				}
				if($this->URLPath == '.' || $this->URLPath == '/' 
					|| $this->URLPath == '\\' )
				{
					$this->URLPath = '';
				}
			}
			
			// URL file
			$this->URLFile = $file ? $file : basename($_SERVER['SCRIPT_FILENAME']);
						
			// Create the link
			if(USE_SHORT_MANIALINKS)
			{
				$link = $this->URLBase;
				$params['rp'] = $this->URLPath.$this->URLFile;
			}
			else
			{
				$link = $this->URLBase.$this->URLPath.$this->URLFile;
			}
		}
		
		// Modify parameters array
		foreach($params as $name=>$value)
		{
			// TODO Check if urlencode/urldecode is needed
			$params[$name] = $name.'='.$value;
		}
		
		// Check if SID needs to be added
		if(SID)
		{
			$params[] = SID;
		}
		
		// Create parameter string
		if(count($params))
		{
			$params = '?'.implode('&', $params); 
		}
		else
		{
			$params = '';
		}
				
		return $link.$params;
	}
}

?>
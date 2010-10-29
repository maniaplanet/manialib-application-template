<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * Request engine
 * 
 * The Request Engine helps handling GET variables and referers as well as 
 * creating links and redirection. It also handles session ID propagation when 
 * the client doesn't accept cookies.
 * 
 * @package ManiaLib
 */
class RequestEngine
{
	/**#@+
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
	/**#@-*/
	
	/**
	 * Use this methode to retrieve a reference on the request object from anywhere in the code
	 * 
	 * @return RequestEngine
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
		$this->params = $_GET;
		if(get_magic_quotes_gpc())
		{
			$this->params = array_map('stripslashes', $this->params);
		}
		$this->requestParams = $this->params;
	}
	
	/**
	 * Retrieves a GET parameter, or the default value if not found
	 * 
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
	 * 
	 * @throws RequestParameterNotFoundException
	 * @param string
	 * @param string Optional human readable name for error dialog
	 * @return mixed
	 */
	function getStrict($name, $humanReadableName=null)
	{
		if(array_key_exists($name, $this->params) && $this->params[$name])
		{
			return $this->params[$name];
		}	
		$humanReadableName = $humanReadableName ? $humanReadableName : $name;
		throw new RequestParameterNotFoundException($humanReadableName);
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
	
	/**
	 * Returns an URL containing all the currently defined GET parameters
	 * 
	 * Example:
	 * <code>
	 * // Current page: http://url/index.php?toto=a&foo=bar
	 * $request = RequestEngine::getInstance();
	 * $request->createLink('page.php'); // Returns http://url/page.php?toto=a&foo=bar
	 * </code>
	 * 
	 * @param string The filename
	 * @param boolean Whether the first parameter is a relative URL (default:
	 * true). Set this parameter to false if you want to create and external
	 * link.
	 * @return string
	 */
	function createLink($file=null, $relativePath=true)
	{
		$arr = $this->params;
		return $this->createLinkString($file, $relativePath, $arr);
	}
	
	/**
	 * Returns an URL with the request parameters specified as method arguments
	 * (eg.  )
	 * 
	 * Example:
	 * <code>
	 * // Current page: http://url/index.php?toto=a&foo=bar&bla=bla
	 * $request = RequestEngine::getInstance();
	 * $request->createLinkArgList("page.php", "toto", "bla"); // Returns http://url/page.php?toto=a&bla=bla
	 * </code>
	 * 
	 * @param string The filename (eg: "index.php" or "admin/login.php")
	 * @return string
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
	 * Returns an URL with the request parameters specified as method arguments
	 * 
	 * @param string The absolute URL
	 * @return string
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
	 * Creates a Manialink redirection to the specified file with GET
	 * parameters specified as method arguments.
	 * 
	 * Example:
	 * <code>
	 * $request->redirectManialink("index.php", "param1", "param2");
	 * </code>
	 * 
	 * @param string The filename of the link target
	 */
	function redirectManialink($file='index.php')
	{
		$arr = func_get_args();
		array_shift($arr);
		array_unshift($arr, $file);
		$link = call_user_func_array(array($this,  'createLinkArgList'), $arr);
		
		Manialink::redirect($link);
	}
	
	/**
	 * Creates a Manialink redirection to the specified absolute URI
	 * 
	 * @param string
	 */
	function redirectManialinkAbsolute($absoluteUri)
	{
		Manialink::redirect($absoluteUri);
	}
	
	/**
	 * Creates a Manialink redirection to the previously registered referer, or
	 * the index if no referer was previously registered
	 */
	function redirectToReferer()
	{
		Manialink::redirect($this->getReferer());
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
				$session = SessionEngine::getInstance();
				$session->set($name, $value);
				$this->registerProtectedParam($name);
			}
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
	 * Returns the referer, or the specified default page, or index.php
	 * @param string
	 */
	function getReferer($default=null)
	{
		$session = SessionEngine::getInstance();
		$referer = $session->get('referer');
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
			return APP_URL.'index.php';
		}
	}
	
	/**
	 * @ignore 
	 */
	function __destruct()
	{
		if($this->registerRefererAtDestruct)
		{
			$session = SessionEngine::getInstance();
			$session->set('referer', rawurlencode($this->registerRefererAtDestruct));
		}
	}
	
	/**
	 * @ignore 
	 */
	protected function createLinkString($file=null, $relativePath=true, $params)
	{
		// Check for context
		if(!isset($_SERVER))
		{
			return $file;
		}
		
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
				$this->URLBase = APP_USE_SHORT_MANIALINKS ? APP_MANIALINK : APP_URL;
			}
			
			// URL path
			if($this->URLPath === null)
			{
				// TODO realpath() is forbidden on "free.fr" hosting :/
				$this->URLPath = str_replace('\\', '/',
					str_ireplace(realpath(APP_WWW_PATH), '',
						realpath(dirname($_SERVER['SCRIPT_FILENAME']))
					));
				$this->URLPath = implode('/', array_filter(
					explode('/', $this->URLPath))).'/';
				if($this->URLPath == '.' || $this->URLPath == '/')
				{
					$this->URLPath = '';
				}
			}
			
			// URL file
			$this->URLFile = $file ? $file : basename($_SERVER['SCRIPT_FILENAME']);
		
			// Create the link
			if(APP_USE_SHORT_MANIALINKS)
			{
				$link = $this->URLBase;
				$params['rp'] = $this->URLPath.$this->URLFile;
			}
			else
			{
				$link = $this->URLBase.$this->URLPath.$this->URLFile;
			}
		}
		
		
		// Create parameter string
		if(count($params))
		{
			$params = '?'.http_build_query($params, '', '&'); 
		}
		else
		{
			$params = '';
		}
				
		return $link.$params;
	}
}

/**
 * @package ManiaLib
 * @ignore
 */
class RequestParameterNotFoundException extends Exception  {}

?>
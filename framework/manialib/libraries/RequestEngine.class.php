<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * Request engine
 * 
 * Used to handle GET parameters and to create hyperlink strings and redirections
 */
class RequestEngine
{
	static private $instance;
	
	protected $requestParams = array();
	protected $params = array();
	protected $protectedParams = array();
	protected $globalParams = array();
	
	protected $URLBase;
	protected $URLPath;
	protected $URLFile;
	
	protected $registerRefererAtDestruct;
	
	/**
	 * Gets the instance
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
	 * Retrieves a request parameter, or the default value if not found
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
	 * Retrieves a request parameter, or throws an exception if not found or null
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
	 * Sets a request parameter. Note that you cannot use "rp" as parameter name
	 * @param string
	 * @param mixed
	 */
	function set($name, $value)
	{
		$this->params[$name] = $value;
	}
	
	/**
	 * Deletes a request parameter
	 * @param mixed
	 */
	function delete($name)
	{
		unset($this->params[$name]);
	}
	
	/**
	 * Restores a request parameter to the value it had when the page was loaded
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
	 * Returns an url with all the currently defined request parameters
	 * @param string The filename (eg: "index.php" or "admin/login.php")
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
	 * Returns an url with the request parameters specified as method arguments
	 * (eg. createLinkArgList("index.php", "id", "page") )
	 * @param string The filename (eg: "index.php" or "admin/login.php")
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
	 * Creates a Manialink redirection to the specified file with request
	 * parameters specified as method arguments (eg. redirectManialink("index.
	 * php", "id", "page") )
	 * @param string The filename (eg: "index.php" or "admin/login.php")
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
	 * @param string
	 */
	function redirectManialinkAbsolute($absoluteUri)
	{
		Manialink::redirect($absoluteUri);
	}
	
	/**
	 * Creates a Manialink redirection to the previously registered referer, or
	 * the index if no referer was previously registedred
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
		// TODO Le register referer est bugg�
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
	
	function __destruct()
	{
		if($this->registerRefererAtDestruct)
		{
			$session = SessionEngine::getInstance();
			$session->set('referer', rawurlencode($this->registerRefererAtDestruct));
		}
	}

	protected function __construct()
	{
		$this->params = $_GET;
		if(get_magic_quotes_gpc())
		{
			$this->params = array_map('stripslashes', $this->params);
		}
		$this->requestParams = $this->params;
	}
	
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
			$params = '?'.(defined('SID') && SID ? SID.'&' : '').http_build_query($params, '', '&'); 
		}
		else
		{
			$params = '';
		}
				
		return $link.$params;
	}
}

class RequestException extends FrameworkException {}

class RequestParameterNotFoundException extends FrameworkUserException 
{
	/**
	 * @param string Human readable name of the parameter that was forgotten
	 */
	function __construct($parameterName)
	{
		parent::__construct('You must specify $<$o'.$parameterName.'$>');
	}
}

?>
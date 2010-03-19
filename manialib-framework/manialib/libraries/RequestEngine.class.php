<?php
/**
 * @author Maxime Raoust
 * @package Manialib
 */

// TODO RequestEngine debug: short manialinks
// TODO RequestEngine: should the parameters be automatically rawurlencod()/rawurldecod() ?

/**
 * <b>Request engine</b>: used to handle GET parameters and to create hyperlink
 * strings and redirections
 */
final class RequestEngine
{
	protected static $instance;
	
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
	 * Retrieves a request parameter, or throws an exception if not found
	 * @param string
	 * @param string Optional human readable name for error dialog
	 * @return mixed
	 */
	function getStrict($name, $humanReadableName=null)
	{
		if(isset($this->params[$name]))
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
		if($name=='rp')
		{
			throw new RequestException('You cannot use "rp" as a request parameter');
		}
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
	
	/**
	 * Creates a Manialink redirection to the specified file with request
	 * parameters specified as method arguments (eg. redirectManialink("index.
	 * php", "id", "page") )
	 * @param string The filename (eg: "index.php" or "admin/login.php")
	 */
	function redirectManialink($file='index.php')
	{
		ob_clean();
		$arr = func_get_args();
		array_shift($arr);
		array_unshift($arr, $file);
		$link = call_user_func_array(array($this,  'createLinkArgList'), $arr);
		header('Content-Type: text/xml; charset=utf-8');
		echo('<redirect>'.$link.'</redirect>');
		exit;
	}
	
	/**
	 * Creates a Manialink redirection to the specified absolute URI
	 * @param string
	 */
	function redirectManialinkAbsolute($absoluteUri)
	{
		ob_clean();
		echo('<redirect>'.$absoluteUri.'</redirect>');
		exit;
	}
	
	/**
	 * Creates a Manialink redirection to the previously registered referer, or
	 * the index if no referer was previously registedred
	 */
	function redirectToReferer()
	{
		ob_clean();
		$link = $this->getReferer();
		echo('<redirect>'.$link.'</redirect>');
		exit;
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
			$this->params = array_filter($this->params, 'stripslashes');
		}
		$this->requestParams = $this->params;
		$this->registerProtectedParam('rp');
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
				$this->URLBase = USE_SHORT_MANIALINKS ? MANIALINK_NAME : APP_URL;
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
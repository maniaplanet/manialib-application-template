<?php
/**
 * Link manager
 * 
 * @author Maxime Raoust
 */

class LinkEngine
{
	private static $instance;
	
	private $params = array();
	private $tempParams = array();
	
	private $protectedParams = array();
	private $globalParams = array();
	
	private $registerRefererAtDestruct;
	
	/**
	 * Constructor can't be called, use Class::getInstance instead
	 */
	private function __construct()
	{
		$this->params = Gpc::getArray();
	}
	
	function __destruct()
	{
		if($this->registerRefererAtDestruct)
		{
			$session = SessionEngine::getInstance();
			$session->set("referer", rawurlencode($this->registerRefererAtDestruct));
		}
	}
	
	/**
	 * Get the instance
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
	 * Reset the URL params
	 * 
	 * @param Bool $temp=false
	 */
	function resetParams()
	{
		$this->params = array();
	}
	
	/**
	 * Set an URL param
	 * 
	 * @param String $name
	 * @param Mixed $value
	 */
	function setParam ($name, $value)
	{
		$this->params[$name] = $value;
	}
	
	/**
	 * Get an URL param
	 * 
	 * @param String $name
	 * @param Mixed $default=null
	 * @return Mixed
	 */
	protected function getParam($name, $default=null)
	{
		if(isset($this->params[$name]))
			return $this->params[$name];
		else
			return $default;
	}
	
	/**
	 * Delete an URL param
	 * 
	 * @param String $name
	 */
	function deleteParam ($name)
	{
		unset($this->params[$name]);
	}
	
	/**
	 * Create the link string
	 * 
	 * @param String $file=null
	 * @param Bool $relativePath=null
	 * @param Array $params
	 * @return String
	 */
	private function createLinkString($file=null, $relativePath=true, $params)
	{		
		// TODO Gérer les sous dossiers dans les liens
		
		// Baseurl
		$link = "";
		if($file==null)
		{
			$file = basename($_SERVER["SCRIPT_FILENAME"]);
		}
		if($relativePath)
		{
			$link = APP_URL;
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
	
	/**
	 * Create an URL string with all the defined params
	 * 
	 * @param String $file=null
	 * @param $relativePath = true
	 * @return String
	 */
	function createLink($file=null, $relativePath=true)
	{
		$arr = $this->params;
		return $this->createLinkString($file, true, $arr);
	}
	
	/**
	 * Create an URL string with the specified params
	 * 
	 * @param String $file=null
	 * @param [String $... ]
	 */
	function createLinkArgList($file=null)
	{
		// Retrieve and check the arg list
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
	 * Redirect using the redirect manialink tag
	 * 
	 * @param String $file=index.php
	 * @param [String $... ]
	 */
	function redirectManialink($file="index.php")
	{
		ob_clean();
		$arr = func_get_args();
		array_shift($arr);
		array_unshift($arr, $file);
		$linkstr = call_user_func_array(array($this,  "createLinkArgList"), $arr);
		echo("<redirect addplayerid=\"1\">$linkstr</redirect>");
		exit;
	}
	
	/**
	 * Redirect using the redirect manialink tag
	 * 
	 * @param String $file=index.php
	 * @param [String $... ]
	 */
	function redirect($absoluteUri)
	{
		ob_clean();
		echo("<redirect>$absoluteUri</redirect>");
		exit;
	}
	
	/**
	 * Redirect to the previously saved referer, or index.php
	 */
	function redirectToReferer()
	{
		ob_clean();
		$linkstr = $this->getReferer();
		echo("<redirect>$linkstr</redirect>");
		exit;
	}
	
	/**
	 * Register a protected URL param. If passed it will be deleted. Use the
	 * param before calling this method.
	 * 
	 * @param String $name
	 */
	function registerProtectedParam($name)
	{
		$this->protectedParams[] = $name;
		unset($this->params[$name]);
	}
	
	/**
	 * Register a global URL param. It will be saved in the session and deleted.
	 * Use the session engine to further retrieve the param
	 * 
	 * @param String $name
	 */
	function registerGlobalParam($name)
	{
		$value = $this->getParam($name, null);
		if($value !== null)
		{
			$session = SessionEngine::getInstance();
			$session->set($name, $value);
			$this->registerProtectedParam($name);
		}
	}
	
	/**
	 * Register the current URL as last page visited. At will be registered
	 * at script destruct. Use self::getReferer() to retrieve it.
	 */
	function registerReferer()
	{
		$session = SessionEngine::getInstance();
		$linkstr = $this->createLink();
		$this->registerRefererAtDestruct = $linkstr;
	}
	
	/**
	 * Get the referer, or the specified default page, or index.php
	 * 
	 * @param String $default=null
	 * @return String
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
	
}
?>
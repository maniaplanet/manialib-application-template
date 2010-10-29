<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 * @subpackage MVC
 */

/**
 * Response engine
 * Allows to pass values between filters, controllers and views
 * @package ManiaLib
 * @subpackage MVC
 * @todo doc
 */
class ResponseEngine
{
	/**
	 * @ignore 
	 */
	private static $instance;

	/**#@+
	 * @ignore 
	 */
	private $vars = array();
	private $body = '';
	private $views = array();
	/**#@-*/
	/**
	 * @var DialogHelper
	 * @ignore
	 */
	public $dialog;

	/**
	 * Gets the instance
	 * @return ResponseEngine
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
	private function __construct() {}

	/**
	 * @ignore 
	 */
	public function __set($name, $value)
	{
		$this->vars[$name] = $value;
	}
	
	/**
	 * @ignore 
	 */
	public function __get($name)
	{
		if(array_key_exists($name, $this->vars))
		{
			return $this->vars[$name];
		}
		else
		{
			return null;
		}
	}
	
	/**
	 * @todo doc 
	 */
	public function get($name, $default=null)
	{
		if(array_key_exists($name, $this->vars))
		{
			return $this->vars[$name];
		}
		else
		{
			return $default;
		}
	}
	
	/**
	 * @todo doc 
	 */
	public function registerDialog(DialogHelper $dialog)
	{
		if($this->dialog)
		{
			throw new DialogAlreadyRegistered;
		}
		$this->dialog = $dialog;
	}
	
	/**
	 * @todo doc 
	 */
	public function registerView($controllerName, $actionName)
	{
		$this->views[] = array($controllerName, $actionName);
	}
	
	/**
	 * @todo doc 
	 */
	public function resetViews()
	{
		$this->views = array();
	}
	
	/**
	 * @todo doc 
	 */
	public function appendBody($content)
	{
		$this->body .= $content;
	}
	
	/**
	 * @ignore
	 */
	public function render()
	{
		View::render('header');
		if($this->dialog)
		{
			View::render($this->dialog->controller, $this->dialog->action);
			Manialink::disableLinks();
		}
		foreach($this->views as $view)
		{
			View::render($view[0], $view[1]);
		}
		View::render('footer');
		
		header('Content-Type: text/xml; charset=utf-8');
		echo $this->body;
	}
}

/**
 * @package ManiaLib
 * @subpackage MVC
 * @ignore
 */
class ResponseEngineException extends MVCException {}

/**
 * @package ManiaLib
 * @subpackage MVC
 * @ignore
 */
class DialogAlreadyRegistered extends ResponseEngineException {}

?>
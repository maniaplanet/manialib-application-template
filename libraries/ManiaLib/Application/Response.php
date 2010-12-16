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
 */
class ManiaLib_Application_Response
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
	 * @var ManiaLib_Application_DialogHelper
	 * @ignore
	 */
	public $dialog;

	/**
	 * Gets the instance
	 * @return ManiaLib_Application_Response
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

	public function registerDialog(ManiaLib_Application_DialogHelper $dialog)
	{
		if($this->dialog)
		{
			throw new ManiaLib_Application_DialogAlreadyRegisteredException;
		}
		$this->dialog = $dialog;
	}

	public function registerView($controllerName, $actionName)
	{
		$this->views[] = array($controllerName, $actionName);
	}
	
	public function resetViews()
	{
		$this->views = array();
	}
	
	public function appendBody($content)
	{
		$this->body .= $content;
	}
	
	public function render()
	{
		ob_start();
		try 
		{
			$appViews = 
				ManiaLib_Config_Loader::$config->application->namespace.
				NAMESPACE_SEPARATOR.
				'Views';
			$frameworkViews = 'ManiaLib'.NAMESPACE_SEPARATOR.'Application'.NAMESPACE_SEPARATOR.'Views';
			$header = NAMESPACE_SEPARATOR.'Header';
			if(class_exists($appViews.$header))
			{
				ManiaLib_Application_View::renderExternal($appViews, 'Header');
			}
			elseif(class_exists($frameworkViews.$header))
			{
				ManiaLib_Application_View::renderExternal($frameworkViews, 'Header');
			}
			
			if($this->dialog)
			{
				// TODO This is not the best way to do it, is it?
				ManiaLib_Application_View::renderExternal($this->dialog->className, null);
				ManiaLib_Gui_Manialink::disableLinks();
			}
			foreach($this->views as $view)
			{
				$view[0] = 
					ManiaLib_Config_Loader::$config->application->namespace.
					NAMESPACE_SEPARATOR.
					'Views'.
					NAMESPACE_SEPARATOR.
					$view[0];
				ManiaLib_Application_View::renderExternal($view[0], $view[1]);
			}
			
			$footer = NAMESPACE_SEPARATOR.'Footer';
			if(class_exists($appViews.$footer))
			{
				ManiaLib_Application_View::renderExternal($appViews, 'Footer');
			}
			elseif(class_exists($frameworkViews.$footer))
			{
				ManiaLib_Application_View::renderExternal($frameworkViews, 'Footer');
			}
			
			$this->body = ob_get_contents();
		}
		catch(Exception $e)
		{
			ob_end_flush();
			throw $e;
		}
		ob_end_clean();
		
		header('Content-Type: text/xml; charset=utf-8');
		echo $this->body;
	}
}


class ManiaLib_Application_ResponseException extends Exception {}
class ManiaLib_Application_DialogAlreadyRegisteredException extends Exception {}

?>
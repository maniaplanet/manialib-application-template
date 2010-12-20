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

	public function getViewClassName($controllerName, $actionName)
	{
		$className =
			ManiaLib_Config_Loader::$config->application->namespace.
			NAMESPACE_SEPARATOR.
			'Views'.
			NAMESPACE_SEPARATOR.
			$controllerName;
		
		if($actionName)
		{
			$className .= NAMESPACE_SEPARATOR.ucfirst($actionName);
		}
			
		return $className;
	}
	
	public function registerDialog(ManiaLib_Application_DialogHelper $dialog)
	{
		if($this->dialog)
		{
			throw new ManiaLib_Application_DialogAlreadyRegisteredException;
		}
		$this->dialog = $dialog;
	}

	/**
	 * You can register a view:
	 *  - by $controllerName, $actionName
	 *  - by $className which must be a instanceof manialib_application_view
	 */
	public function registerView(/* Polymorphic */)
	{
		$args = func_get_args();
		switch(count($args))
		{
			case 1:
				$className = reset($args);
				break;
			
			case 2:
				$className = call_user_func_array(
					array($this, 'getViewClassName'), func_get_args());
				break;
				
			default:
				throw new BadMethodCallException('Too many arguments');
		}
		$this->views[] = $className;
	}
	
	public function resetViews()
	{
		$this->views = array();
	}
	
	public function appendBody($content)
	{
		$this->body .= $content;
	}
	
	protected function registerHeaderFooterDialog()
	{
		if($this->dialog)
		{
			array_unshift($this->views, $this->dialog->className);
		}
		
		$_ = NAMESPACE_SEPARATOR;
		$APPNS = ManiaLib_Config_Loader::$config->application->namespace;
		
		$appViews = $APPNS.$_.'Views';
		$frameworkViews = 'ManiaLib'.$_.'Application'.$_.'Views';
		
		$header = $_.'Header';
		$footer = $_.'Footer';
		
		if(class_exists($appViews.$header))
		{
			array_unshift($this->views, $appViews.$header);
		}
		elseif(class_exists($frameworkViews.$header))
		{
			array_unshift($this->views, $frameworkViews.$header);
		}
		
		if(class_exists($appViews.$footer))
		{
			array_push($this->views, $appViews.$footer);
		}
		elseif(class_exists($frameworkViews.$footer))
		{
			array_push($this->views, $frameworkViews.$footer);
		}
	}
	
	public function render()
	{
		$this->registerHeaderFooterDialog();
		
		ob_start();
		try 
		{
			foreach($this->views as $view)
			{
				ManiaLib_Application_View::render($view);
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
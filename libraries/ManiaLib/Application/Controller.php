<?php
/**
 * MVC framwork magic happens here!
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 * @subpackage MVC
 */

/**
 * Action controller
 * This is the base class for all controllers. Extend ManiaLib_Application_Controller to create
 * a new controller for your application.
 * <b>Naming conventions</b>
 * <ul>
 * <li>Controller classes are suffixed by "Controller", naming is regular CamelCase class convention</li>
 * <li>Actions are regular camelCase convention</li>
 * <li>When creating links with the Request engine, use class and method names eg. createLink('SomeController', 'someAction')</li>
 * <li>Views folders and files use the same naming conventions as the classes/methods (eg. view/SomeController/someAction.php)</li>
 * <li>The URLs will be lowercase (camelCase is mapped to underscore-separated names)</li>
 * <li>You can change the default separator ("_") in the config</li>
 * </ul>
 * <b>Example</b>
 * <code>
 * class HomeController extends ManiaLib_Application_Controller
 * {
 *    function __construct()
 *    {
 *        parent::__construct();
 *        $this->addFilter(new RegisterRequestParametersFilter());
 *    }
 *    
 *    function index() {} // mapped by /home/index/
 *    
 *    function anotherAction() {} // mapped by /home/another_action/
 * }
 * </code>
 * @package ManiaLib
 * @subpackage MVC
 */
class ManiaLib_Application_Controller
{
	/**
	 * Overrride this to define the controller's default action name
	 * @var string
	 */
	protected $defaultAction;
	/**
	 * Current controller name
	 */	
	protected $controllerName;
	/**
	 * Current action name
	 */
	protected $actionName;
	/**
	 * @var array[ManiaLib_Application_Filterable]
	 * @ignore
	 */
	protected $filters = array();
	/**
	 * @var array[ReflectionMethod]
	 * @ignore
	 */
	protected $reflectionMethods = array();
	/**
	 * @var ManiaLib_Application_Request
	 */
	protected $request;
	/**
	 * @var ManiaLib_Application_Session
	 */
	protected $session;
	/**
	 * @var ManiaLib_Application_Response
	 */
	protected $response;
	
	protected $enableSession = true;

	/**
	 * @ignore
	 */
	final public static function dispatch()
	{
		$request = ManiaLib_Application_Request::getInstance();
		self::getController($request->getController())->launch();
		ManiaLib_Application_Response::getInstance()->render();
	}
	
	/**
	 * @return ManiaLib_Application_Controller
	 * @ignore
	 */
	final static public function getController($controllerName)
	{
		$controllerClass = 
			ManiaLib_Config_Loader::$config->application->namespace.NAMESPACE_SEPARATOR.
			'Controllers'.NAMESPACE_SEPARATOR.
			$controllerName;
		if(!class_exists($controllerClass))
		{
			throw new ControllerNotFoundException($controllerClass);
		}	
		return new $controllerClass($controllerName);
	}

	/**
	 * If you want to do stuff at instanciation, override self::onConstruct()
	 * @ignore
	 */
	function __construct($controllerName)
	{
		$this->controllerName = $controllerName;
		if(!$this->defaultAction)
		{
			$this->defaultAction = ManiaLib_Config_Loader::$config->application->defaultAction;
		}
		$this->request = ManiaLib_Application_Request::getInstance();
		$this->response = ManiaLib_Application_Response::getInstance();
		if($this->enableSession)
		{
			$this->session = ManiaLib_Application_Session::getInstance();
		}
		$this->onConstruct();
	}
	
	/**
	 * Stuff to be executed when the controller is instanciated; override this in your controllers 
	 */
	protected function onConstruct(){}

	/**
	 * Add a filter to the curent controller
	 * Typically you should call that in your controller's onConstruct() method
	 * 
	 * Example:
	 * <code>
	 * class SomeStuffController extends ManiaLib_Application_Controller
	 * {
	 *     //...
	 *     function onConstruct()
	 *     {
	 *			$this->addFilter(new UserAgentCheckFilter());      
	 *     }
	 *     //...
	 * }
	 * </code>
	 */
	final protected function addFilter(ManiaLib_Application_Filterable $filter)
	{
		$this->filters[] = $filter;
	}

	/**
	 * @return array[ManiaLib_Application_Filterable]
	 * @ignore
	 */
	final public function getFilters()
	{
		return $this->filters;
	}

	/**
	 * Executes an action from within another action
	 */
	final protected function chainAction($controllerName, $actionName)
	{
		if($controllerName==null ||  $controllerName == $this->controllerName)
		{
			$this->checkActionExists($actionName);
			$this->executeAction($actionName);
		}
		else
		{
			$this->executeActionCrossController($controllerName,$actionName);
		}
	}

	/**
	 * Executes an action from within another action and override the view from the first action
	 */
	final protected function chainActionAndView($controllerName, $actionName, $resetViews = true)
	{
		if($resetViews)
		{
			$this->response->resetViews();
		}
		if($controllerName==null || $controllerName == $this->controllerName)
		{
			$this->checkActionExists($actionName);
			$this->response->registerView($this->controllerName, $actionName);
			$this->executeAction($actionName);
		}
		else
		{
			$this->response->registerView($controllerName, $actionName);
			$this->executeActionCrossController($controllerName, $actionName);
		}
	}

	/**
	 * @ignore
	 */
	final public function checkActionExists($actionName)
	{
		if(!array_key_exists($actionName, $this->reflectionMethods))
		{
			try
			{
				$this->reflectionMethods[$actionName] = new ReflectionMethod(get_class($this),$actionName);
			}
			catch(Exception $e)
			{
				throw new ActionNotFoundException($actionName);
			}
		}
		if(!$this->reflectionMethods[$actionName]->isPublic())
		{
			throw new ActionNotFoundException($actionName.' (Method "'.$actionName.'()" must be public)');
		}
		if($this->reflectionMethods[$actionName]->isFinal())
		{
			throw new Exception($actionName.' (Method "'.$actionName.'()" must not be final)');
		}
	}

	/**
	 * @ignore
	 */
	final protected function executeActionCrossController($controllerName, $actionName)
	{
		$controller = self::getController($controllerName);
		$controller->checkActionExists($actionName);
		$controllerFilters = $controller->getFilters();
		foreach($controllerFilters as $controllerFilter)
		{
			if(!in_array($controllerFilter,$this->filters))
			{
				$controllerFilter->preFilter();
			}
		}
		$controller->executeAction($actionName);
		foreach($controllerFilters as $controllerFilter)
		{
			if(!in_array($controllerFilter,$this->filters))
			{
				$controllerFilter->postFilter();
			}
		}
	}

	/**
	 * @ignore
	 */
	final public function executeAction($actionName)
	{
		if(!array_key_exists($actionName, $this->reflectionMethods))
		{
			try
			{
				$this->reflectionMethods[$actionName] =
				new ReflectionMethod(get_class($this),$actionName);
			}
			catch(Exception $e)
			{
				throw new ActionNotFoundException($actionName);
			}
		}

		$callParameters = array();
		$requiredParameters = $this->reflectionMethods[$actionName]->getParameters();
		foreach($requiredParameters as $parameter)
		{
			if($parameter->isDefaultValueAvailable())
			{
				$callParameters[] = $this->request->get($parameter->getName(), $parameter->getDefaultValue());
			}
			else
			{
				$pname = $parameter->getName();
				$pmessage = 'Undefined parameter: $<$o'.$pname.'$>';
				$callParameters[] = $this->request->getStrict($pname, $pmessage);
			}
		}
		
		$this->actionName = $actionName;
		call_user_func_array(array($this, $actionName), $callParameters);
	}

	/**
	 * @ignore
	 */
	final protected function launch()
	{
		$actionName = $this->request->getAction($this->defaultAction);
		if(!$actionName) $actionName = $this->defaultAction;

		$this->checkActionExists($actionName);

		$this->response->registerView($this->controllerName, $actionName);

		foreach($this->filters as $filter)
		{
			$filter->preFilter();
		}

		$this->executeAction($actionName);

		foreach(array_reverse($this->filters) as $filter)
		{
			$filter->postFilter();
		}
	}
}

/**
 * @package ManiaLib
 * @subpackage MVC
 * @ignore
 */
class ControllerNotFoundException extends Exception {}

/**
 * @package ManiaLib
 * @subpackage MVC
 * @ignore
 */
class ActionNotFoundException extends Exception {}

?>
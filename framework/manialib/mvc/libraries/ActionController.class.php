<?php
/**
 * MVC framwork magic happens here!
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLibMvc
 */

/**
 * @ignore
 */
require_once(APP_MVC_FRAMEWORK_EXCEPTIONS_PATH.'MVCException.class.php'); 

/**
 * Action controller
 * 
 * This is the base class for all controllers. Extend ActionController to create
 * a new controller for your application.
 * 
 * Naming conventions:
 * <ul>
 * <li>class mysuperstuffController</li>
 * <li>public function mysuperstuffController::mysuperaction()</li>
 * </ul>
 * Note the lowercase names to ensure that URLS are all lowercase
 * 
 * Example:
 * <code>
 * class homeController extends ActionController
 * {
 *    function __construct()
 *    {
 *        parent::__construct();
 *        $this->addFilter(new RegisterRequestParametersFilter());
 *    }
 *    
 *    function index() {}
 *    
 *    function another_action() {}
 * }
 * </code>
 */
class ActionController
{
	/**
	 * Overrride this to define the controller's default action name
	 * @var string
	 */
	protected $defaultAction = URL_PARAM_DEFAULT_ACTION;
	/**
	 * Current controller name 
	 */	
	protected $controllerName;
	/**
	 * @var array[Filterable]
	 */
	protected $filters = array();
	/**
	 * @var array[ReflectionMethod]
	 */
	protected $reflectionMethods = array();
	/**
	 * @var RequestEngineMVC
	 */
	protected $request;
	/**
	 * @var SessionEngine
	 */
	protected $session;
	/**
	 * @var ResponseEngine
	 */
	protected $response;
	
	final public static function dispatch()
	{
		$request = RequestEngineMVC::getInstance();
		self::getController($request->getController())->launch();
		ResponseEngine::getInstance()->render();
	}
	
	/**
	 * @return ActionController
	 */
	final static public function getController($controllerName)
	{
		$controllerClass = $controllerName.'Controller';
		$controllerFilename = APP_MVC_CONTROLLERS_PATH.$controllerClass.'.class.php';

		if (!file_exists($controllerFilename))
		{
			throw new ControllerNotFoundException($controllerName);
		}

		require_once($controllerFilename);
		return new $controllerClass($controllerName);
	}

	/**
	 * Call the parent constructor when you override it in your controllers!
	 */
	function __construct($controllerName)
	{
		$this->controllerName = $controllerName;
		$this->request = RequestEngineMVC::getInstance();
		$this->response = ResponseEngine::getInstance();
		$this->session = SessionEngine::getInstance();
	}

	final protected function addFilter(Filterable $filter)
	{
		$this->filters[] = $filter;
	}

	/**
	 * @return array[Filterable]
	 */
	final public function getFilters()
	{
		return $this->filters;
	}

	final protected function chainAction($controllerName=null, $actionName)
	{
		if($controllerName==null || $controllerName.'Controller' == get_class($this))
		{
			$this->checkActionExists($actionName);
			$this->executeAction($actionName);
		}
		else
		{
			$this->executeActionCrossController($controllerName,$actionName);
		}
	}

	final protected function chainActionAndView($controllerName=null, $actionName, $resetViews = true)
	{
		if($resetViews)
		{
			$this->response->resetViews();
		}
		if($controllerName==null || $controllerName.'Controller' == get_class($this))
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

	final public function checkActionExists($actionName)
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
		if(!$this->reflectionMethods[$actionName]->isPublic())
		{
			throw new ActionNotFoundException($actionName.' (Method must be public)');
		}
		if($this->reflectionMethods[$actionName]->isFinal())
		{
			throw new Exception($actionName.' (Method must not be final)');
		}
	}

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
				$callParameters[] = $this->request->get($parameter->name, $parameter->getDefaultValue());
			}
			else
			{
				$callParameters[] = $this->request->getStrict($parameter->name);
			}
		}

		call_user_func_array(array($this, $actionName), $callParameters);
	}

	final protected function launch()
	{
		$controllerName = $this->request->getController();
		$actionName = $this->request->getAction($this->defaultAction);
		if(!$actionName) $actionName = $this->defaultAction;

		$this->checkActionExists($actionName);

		$this->response->registerView($controllerName, $actionName);

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

	final protected function showDebugMessage($message)
	{
		if(APP_DEBUG_LEVEL == DEBUG_OFF)
		{
			throw new MVCException('ActionController::showDebugMessage() is only available in debug mode!');
		}

		$this->response->dialogTitle = 'Debug message';
		$this->response->dialogMessage = print_r($message, true);
		$this->response->dialogButtonLabel = 'Quarante-deux';
		$this->response->dialogButtonManialink = $this->request->getReferer();

		$this->response->resetViews();
		$this->response->registerDialog('dialogs', 'generic_dialog');
	}
}

class ControllerNotFoundException extends MVCException {}
class ActionNotFoundException extends MVCException {}

?>
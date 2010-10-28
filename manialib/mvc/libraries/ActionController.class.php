<?php
/**
 * MVC framwork magic happens here!
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib_MVC
 */

/**
 * @ignore
 */
require_once(APP_MVC_FRAMEWORK_EXCEPTIONS_PATH.'MVCException.class.php'); 

/**
 * Action controller
 * This is the base class for all controllers. Extend ActionController to create
 * a new controller for your application.
 * <b>Naming conventions</b>
 * <ul>
 * <li>Controller classes are suffixed by "Controller", naming is regular CamelCase class convention</li>
 * <li>Actions are regular camelCase convention</li>
 * <li>When creating links with the Request engine, use class and method names eg. createLink('SomeController', 'someAction')</li>
 * <li>Views folders and files use the same naming conventions as the classes/methods (eg. view/SomeController/someAction.php)</li>
 * <li>The URLs will be lowercase (camelCase is mapped to underscore-separated names)</li>
 * <li>You can change the default separator ("_") in the config using the APP_MVC_URL_SEPARATOR constant</li>
 * </ul>
 * <b>Example</b>
 * <code>
 * class HomeController extends ActionController
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
 * @package ManiaLib_MVC
 * @todo Think about "plugins" eg. you want to do a shoutbox plugin, how everything works?
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
	 * @ignore
	 */
	protected $filters = array();
	/**
	 * @var array[ReflectionMethod]
	 * @ignore
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

	/**
	 * @ignore
	 */
	final public static function dispatch()
	{
		$request = RequestEngineMVC::getInstance();
		self::getController($request->getController())->launch();
		ResponseEngine::getInstance()->render();
	}
	
	/**
	 * @return ActionController
	 * @ignore
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
	 * If you want to do stuff at instanciation, override self::onConstruct()
	 * @ignore
	 */
	function __construct($controllerName)
	{
		$this->controllerName = $controllerName;
		$this->request = RequestEngineMVC::getInstance();
		$this->response = ResponseEngine::getInstance();
		$this->session = SessionEngine::getInstance();
		$this->onConstruct();
	}
	
	/**
	 * Stuff to be executed when the controller is instanciated; override this in your controllers 
	 */
	protected function onConstruct(){}

	/**
	 * @todo doc
	 */
	final protected function addFilter(Filterable $filter)
	{
		$this->filters[] = $filter;
	}

	/**
	 * @return array[Filterable]
	 * @ignore
	 */
	final public function getFilters()
	{
		return $this->filters;
	}

	/**
	 * @todo doc
	 */
	final protected function chainAction($controllerName=null, $actionName)
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
	 * @todo doc
	 */
	final protected function chainActionAndView($controllerName=null, $actionName, $resetViews = true)
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
				$callParameters[] = $this->request->getStrict($parameter->getName());
			}
		}

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

	/**
	 * @todo doc
	 */
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

/**
 * @package ManiaLib_MVC
 * @ignore
 */
class ControllerNotFoundException extends MVCException {}

/**
 * @package ManiaLib_MVC
 * @ignore
 */
class ActionNotFoundException extends MVCException {}

?>
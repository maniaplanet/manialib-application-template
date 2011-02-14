<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\Application;

/**
 * Action controller
 * This is the base class for all controllers. Extend \ManiaLib\Application\Controller to create
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
 * class HomeController extends \ManiaLib\Application\Controller
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
 */
class Controller
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
	 * @var array[\ManiaLib\Application\Filterable]
	 * @ignore
	 */
	protected $filters = array();
	/**
	 * @var array[ReflectionMethod]
	 * @ignore
	 */
	protected $reflectionMethods = array();
	/**
	 * @var \ManiaLib\Application\Request
	 */
	protected $request;
	/**
	 * @var \ManiaLib\Session\Session
	 */
	protected $session;
	/**
	 * @var \ManiaLib\Application\Response
	 */
	protected $response;
	
	/**
	 * @ignore
	 */
	final public static function dispatch()
	{
		$request = \ManiaLib\Application\Request::getInstance();
		self::factory($request->getController())->launch();
		\ManiaLib\Application\Response::getInstance()->render();
	}
	
	/**
	 * @return \ManiaLib\Application\Controller
	 * @ignore
	 */
	final static public function factory($controllerName)
	{
		$controllerClass = 
			Config::getInstance()->namespace.NAMESPACE_SEPARATOR.
			'Controllers'.NAMESPACE_SEPARATOR.
			$controllerName;
		if(!class_exists($controllerClass))
		{
			throw new ControllerNotFoundException('Controller not found: /'.$controllerName.'/');
		}	
		return new $controllerClass($controllerName);
	}

	/**
	 * If you want to do stuff at instanciation, override self::onConstruct()
	 * @ignore
	 */
	protected function __construct($controllerName)
	{
		$this->controllerName = $controllerName;
		if(!$this->defaultAction)
		{
			$this->defaultAction = Config::getInstance()->defaultAction;
		}
		$this->request = \ManiaLib\Application\Request::getInstance();
		$this->response = \ManiaLib\Application\Response::getInstance();
		if(\ManiaLib\Session\Config::getInstance()->enabled)
		{
			$this->session = \ManiaLib\Session\Session::getInstance();
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
	 * class SomeStuffController extends \ManiaLib\Application\Controller
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
	final protected function addFilter(\ManiaLib\Application\Filterable $filter)
	{
		$this->filters[] = $filter;
	}

	/**
	 * @return array[\ManiaLib\Application\Filterable]
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
				$this->reflectionMethods[$actionName] = new \ReflectionMethod(get_class($this),$actionName);
			}
			catch(\Exception $e)
			{
				throw new ActionNotFoundException(
					'Action not found: /'.$this->controllerName.'/'.$actionName.'/');
			}
		}
		if(!$this->reflectionMethods[$actionName]->isPublic())
		{
			throw new ActionNotFoundException(
				'Action not found: /'.$this->controllerName.'/'.$actionName.'/');
		}
		if($this->reflectionMethods[$actionName]->isFinal())
		{
			throw new ActionNotFoundException(
				'Action not found: /'.$this->controllerName.'/'.$actionName.'/');
		}
	}

	/**
	 * @ignore
	 */
	final protected function executeActionCrossController($controllerName, $actionName)
	{
		$controller = self::factory($controllerName);
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
				new \ReflectionMethod(get_class($this),$actionName);
			}
			catch(\Exception $e)
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

class ControllerNotFoundException extends UserException{}
class ActionNotFoundException extends UserException {}

?>
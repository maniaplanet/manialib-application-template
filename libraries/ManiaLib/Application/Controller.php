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
	 * @var \ManiaLib\Application\Session
	 */
	protected $session;
	/**
	 * @var \ManiaLib\Application\Response
	 */
	protected $response;

	/**
	 * @return \ManiaLib\Application\Controller
	 * @ignore
	 */
	final static public function factory($controllerName)
	{
		$controllerClass =
			Config::getInstance()->namespace.'\\'.
			'Controllers'.'\\'.
			$controllerName;
		if(!class_exists($controllerClass))
		{
			throw new ControllerNotFoundException('Controller not found: /'.$controllerName.'/');
		}
		
		$viewsNS =& Config::getInstance()->viewsNS;
		$currentViewsNS = Config::getInstance()->namespace.'\\Views\\';
		if(!in_array($currentViewsNS, $viewsNS))
		{
			array_unshift($viewsNS, $currentViewsNS);
		}
		
		return new $controllerClass($controllerName);
	}

	/**
	 * @ignore
	 */
	final function launch($actionName)
	{
		$actionName = $actionName ? : $this->defaultAction;

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
		$this->session = \ManiaLib\Application\Session::getInstance();
		$this->onConstruct();
	}

	/**
	 * Stuff to be executed when the controller is instanciated; override this in your controllers
	 */
	protected function onConstruct()
	{
		
	}

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
	 * 			$this->addFilter(new UserAgentCheckFilter());
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
	 * Executes an action from within another action
	 * @deprecated Use executeAction
	 */
	final protected function chainAction($actionName)
	{
		$this->executeAction($actionName, false);
	}

	/**
	 * Executes an action from within another action and override the view from the first action
	 * @deprecated Use executeAction
	 */
	final protected function chainActionAndView($actionName, $resetViews = true)
	{
		$this->executeAction($actionName, true, $resetViews);
	}

	/**
	 * @ignore
	 */
	final protected function checkActionExists($actionName)
	{
		if(!array_key_exists($actionName, $this->reflectionMethods))
		{
			try
			{
				$this->reflectionMethods[$actionName] = new \ReflectionMethod(get_class($this), $actionName);
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

	protected function executeAction($actionName, $registerView=true, $resetViews=false)
	{
		$this->checkActionExists($actionName);

		if($resetViews)
		{
			$this->response->resetViews();
		}

		if($registerView)
		{
			$this->response->registerView($this->response->getViewClassName($this->controllerName, $actionName));
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
	 * @return boolean Whether it was confirmed or not
	 * @deprecated remove this now that we can make dialogs in maniascript
	 */
	final protected function quickConfirmDialog($message)
	{
		if(!$this->request->get('confirm'))
		{
			$d = new DialogHelper('\ManiaLib\Application\Views\Dialogs\TwoButtons');
			$d->title = 'Confirm';
			$d->message = $message;
			$d->button2Manialink = $this->request->getReferer();
			$this->request->set('confirm', rand());
			$d->buttonManialink = $this->request->createLink();
			$this->request->delete('confirm');
			$this->response->registerDialog($d);
			return false;
		}
		else
		{
			$this->request->delete('confirm');
			return true;
		}
	}

}

class ControllerNotFoundException extends UserException
{
	
}

class ActionNotFoundException extends UserException
{
	
}

?>
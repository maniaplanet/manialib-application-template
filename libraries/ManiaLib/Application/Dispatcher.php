<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2892 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-03-10 15:24:25 +0100 (jeu., 10 mars 2011) $:
 */

namespace ManiaLib\Application;

class Dispatcher extends \ManiaLib\Utils\Singleton
{
	const PATH_INFO_OVERRIDE_PARAM = 'ml-forcepathinfo';
	
	/**
	 * @var bool
	 */
	protected $running;
	/**
	 * @var string
	 */
	protected $pathInfo;
	/**
	 * @var string
	 */
	protected $controller;
	/**
	 * @var string
	 */
	protected $action;
	/**
	 * @var string
	 */
	protected $calledURL;
	
	function run()
	{
		if($this->running)
		{
			throw new \Exception(get_called_class().'::run() was previously called!');
		}
		$this->running = true;
		$defaultController = Config::getInstance()->defaultController;
		
		$request = Request::getInstance();
		if($request->exists(self::PATH_INFO_OVERRIDE_PARAM))
		{
			$route = $request->get(self::PATH_INFO_OVERRIDE_PARAM, '/');
			$request->delete(self::PATH_INFO_OVERRIDE_PARAM);
		}
		else
		{
			$route = \ManiaLib\Utils\Arrays::getNotNull($_SERVER, 'PATH_INFO', '/');
		}
		
		$this->pathInfo = $route;
		
		$route = substr($route, 1); // Remove starting /
		$route = explode('/', $route, 2);
		
		$this->controller = \ManiaLib\Utils\Arrays::getNotNull($route, 0, $defaultController);
		$this->controller = Route::separatorToUpperCamelCase($this->controller);
		
		$this->action = \ManiaLib\Utils\Arrays::get($route, 1);
		$this->action = $this->action ? Route::separatorToCamelCase($this->action) : '/';
		$this->action = substr($this->action, 0, -1);
		
		$this->calledURL = $request->createLink(Route::CUR, Route::CUR);
		
		try 
		{
			Controller::factory($this->controller)->launch();
			Response::getInstance()->render();
		}
		catch(\Exception $e )
		{
			ErrorHandling::exceptionHandler($e);
			Response::getInstance()->render();
		}
	}
	
	function getController()
	{
		return $this->controller;
	}

	function getAction($defaultAction = null)
	{
		return $this->action ? $this->action : $defaultAction;
	}
	
	function getPathInfo()
	{
		return $this->pathInfo;	
	}
	
	function getCalledURL()
	{
		return $this->calledURL;
	}
} 

?>
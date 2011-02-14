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
 * View features
 */
abstract class View
{
	/**
	 * @var \ManiaLib\Application\Request
	 */
	protected $request;
	/**
	 * @var \ManiaLib\Application\Response
	 */
	protected $response;
	protected $controllerName;
	protected $actionName;
	/**
	 * Set to true to cache the result of self::display
	 * For now it is experimental so you should not use it unless you know
	 * what you are doing... 
	 */
	public $cache = false;
	
	static function render($viewClass)
	{
		if(!class_exists($viewClass))
		{
			throw new ViewNotFoundException('View not found: '.$viewClass);
		}
		$view = new $viewClass();
		
		if($view->cache)
		{
			$cache = \ManiaLib\Cache\Cache::getInstance();
			$key = \ManiaLib\Cache\Cache::getUniqueAppCacheKeyPrefix().'_'.$viewClass;
			if($cache->exists($key))
			{
				try 
				{
					\ManiaLib\Gui\Manialink::appendXML($cache->fetch($key));
				}
				catch(\Exception $e)
				{
					$cache->delete($key);
					throw $e;
				}
			}
			else
			{
				\ManiaLib\Gui\Manialink::beginFrame();
				$node = end(\ManiaLib\Gui\Manialink::$parentNodes);
				$view->display();
				$xml = \ManiaLib\Gui\Manialink::$domDocument->saveXML($node);
				\ManiaLib\Gui\Manialink::endFrame();
				$cache->store($key, $xml);
			}
		}
		else
		{
			$view->display();
		}
		
		if($view instanceof \ManiaLib\Application\Views\Dialogs\DialogInterface)
		{
			\ManiaLib\Gui\Manialink::disableLinks();
		}
	}
	
	final protected function __construct()
	{
		$this->request = \ManiaLib\Application\Request::getInstance();
		$this->response = \ManiaLib\Application\Response::getInstance();
		$this->onConstruct();
	}

	final protected function renderSubView($viewName)
	{
		$className = get_class($this);
		$className = explode(NAMESPACE_SEPARATOR, $className);
		array_pop($className);
		array_push($className, ucfirst($viewName));
		$className = implode(NAMESPACE_SEPARATOR, $className);
		self::render($className);
	}
	
	protected function onConstruct() {}
	
	abstract function display();
}

class ViewNotFoundException extends UserException {}

?>
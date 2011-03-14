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
 * Response engine
 * Allows to pass values between filters, controllers and views
 */
class Response  extends \ManiaLib\Utils\Singleton
{
	protected $vars;
	protected $body;
	protected $views;
	
	/**
	 * @var \ManiaLib\Application\DialogHelper
	 */
	public $dialog;
	protected $registerDefaultViews = true;
	protected $showManiaHomeButton = true;

	protected $renderer;
	
	function __construct()
	{
		$this->vars = array();
		$this->views = array();
		$this->body = '';
		
		$config = Config::getInstance();
		
		$this->registerDefaultViews = !$config->webapp;
		$this->renderer = $config->getRenderer();
		
		if(!class_exists($this->renderer))
		{
			throw new \Exception(sprintf('%s does not exists', $this->renderer));
		}
	}
	
	public function __set($name, $value)
	{
		$this->vars[$name] = $value;
	}
	
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
	
	/**
	 * Returns all defined response vars
	 * @return array
	 */
	public function getAll()
	{
		$params = $this->vars;
		$params['dialog'] = $this->dialog;
		return $params;
	} 

	public function getViewClassName($controllerName, $actionName)
	{
		$className =
			Config::getInstance()->namespace.
			'\\'.
			'Views'.
			'\\'.
			$controllerName;
		
		if($actionName)
		{
			$className .= '\\'.ucfirst($actionName);
		}
			
		return $className;
	}
	
	public function registerDialog(\ManiaLib\Application\DialogHelper $dialog)
	{
		if($this->dialog)
		{
			throw new \Exception('Dialog already registered');
		}
		$this->dialog = $dialog;
	}

	/**
	 * ManiaLib\Application\Response::registerView() now only takes one 
	 * parameter: the view name.
	 * 
	 * It can be a class name when using ManiaLib views for Manialinks 
	 * (eg. ManiaLibDemo\Views\Home\Index)
	 * 
	 * It can also be a ressource name when using Smarty templates: it is the 
	 * filename starting from the ressource folder, less the extension 
	 * (eg. ManiaLib\Views\Example will map the the file: 
	 * APP_PATH/ressources/ManiaLib/Views/Example.tpl)
	 */
	public function registerView($viewName)
	{
		if(func_num_args() != 1)
		{
			throw new \BadMethodCallException(get_called_class().'::registerView() '.
				'now only takes one parameter (the view name)');
		}
		$this->views[] = $viewName;
	}
	
	public function resetViews()
	{
		$this->views = array();
	}
	
	/**
	 * @deprecated
	 */
	public function appendBody($content)
	{
		$this->body .= $content;
	}
	
	function disableDefaultViews()
	{
		$this->registerDefaultViews = false;
	}
	
	function hideManiaHomeButton()
	{
		$this->showManiaHomeButton = false;
	}
	
	protected function registerDefaultViews()
	{
		if($this->dialog)
		{
			array_unshift($this->views, $this->dialog->className);
		}
		
		if($this->showManiaHomeButton)
		{
			$maniaHomeConfig = \ManiaLib\ManiaHome\Config::getInstance();
			if($maniaHomeConfig->manialink)
			{
				$this->registerView('\\ManiaLib\\ManiaHome\\BookmarkButtonView');
			}
		}
		
		$config = Config::getInstance();
		$applicationViewsNS = $config->getApplicationViewsNS();
		$maniaLibViewsNS = $config->getManiaLibViewsNS();
		
		if(class_exists($applicationViewsNS.'Header'))
		{
			array_unshift($this->views, $applicationViewsNS.'Header');
		}
		elseif(class_exists($maniaLibViewsNS.'Header'))
		{
			array_unshift($this->views, $maniaLibViewsNS.'Header');
		}
		
		if(class_exists($applicationViewsNS.'Footer'))
		{
			array_push($this->views, $applicationViewsNS.'Footer');
		}
		elseif(class_exists($maniaLibViewsNS.'Footer'))
		{
			array_push($this->views, $maniaLibViewsNS.'Footer');
		}
	}
	
	function registerErrorView()
	{
		$this->disableDefaultViews();
		$this->resetViews();
		
		$config = Config::getInstance();
		$applicationViewsNS = $config->getApplicationViewsNS();
		$maniaLibViewsNS = $config->getManiaLibViewsNS();
		
		if(call_user_func(array($this->renderer, 'exists'), $applicationViewsNS.'Error'))
		{
			 $this->registerView($applicationViewsNS.'Error');
		}
		elseif(call_user_func(array($this->renderer, 'exists'), $maniaLibViewsNS.'Error'))
		{
			$this->registerView($maniaLibViewsNS.'Error');
		}
	}
	
	public function render()
	{
		if($this->registerDefaultViews)
		{
			$this->registerDefaultViews();
		}
		
		ob_start();
		try 
		{
			foreach($this->views as $view)
			{
				call_user_func(array($this->renderer, 'render'), $view);
			}
			$this->body = ob_get_contents();
		}
		catch(\Exception $e)
		{
			ob_end_clean();
			throw $e;
		}
		ob_end_clean();
		
		call_user_func(array($this->renderer, 'header'));
		echo $this->body;
	}
}

?>
<?php 
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 3021 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-03-16 20:56:42 +0100 (mer., 16 mars 2011) $:
 */

namespace ManiaLib\Application\Rendering;

use ManiaLib\Application\Route;

class Smarty extends \ManiaLib\Utils\Singleton implements RendererInterface
{
	/**
	 * @var \Smarty
	 */
	protected $smarty;
	protected $template;
	protected $rendered = false;
	
	static function render($viewName)
	{
		$that = static::getInstance();
		if($that->rendered)
		{
			throw new \Exception(sprintf(
				'You can only register 1 view while using %s', get_called_class()));
		}
		
		if(!static::exists($viewName))
		{
			throw new ViewNotFoundException('View not found: '.$viewName);
		}
		
		// Add some useful vars to the response
		$config = \ManiaLib\Application\Config::getInstance();
		$session = \ManiaLib\Session\Session::getInstance();
		$response = \ManiaLib\Application\Response::getInstance();
		$tracking = \ManiaLib\Application\Tracking\Config::getInstance();
		
		$response->login = $session->login;
		$response->mediaURL = $config->getMediaURL();
		$response->appURL = $config->getLinkCreationURL();
		$response->trackingAccount = $tracking->account;
		
		// Assign all response vars to the template
		$vars = $response->getAll();
		$smarty = $that->smarty;
		$callback = function ($value, $key) use ($smarty) 
		{
			call_user_func(array($smarty, 'assign'), $key, $value);
		};
		array_walk($vars, $callback);
		
		// Rendering
		$viewName = str_replace('\\', DIRECTORY_SEPARATOR, $viewName);
		$that->smarty->display($viewName.'.tpl');
		$that->rendered = true;
	}
	
	static function exists($viewName)
	{
		$that = static::getInstance();
		$viewName = str_replace('\\', DIRECTORY_SEPARATOR, $viewName);
		return $that->smarty->templateExists($viewName.'.tpl');
	}
	
	static function header()
	{
		header('Content-Type: text/html');
		header('X-Powered-By: ManiaLib 2');
	}
	
	protected function __construct()
	{
		require_once 'Smarty/Smarty.class.php';
		
		$smartyConfig = SmartyConfig::getInstance();
		
		$this->smarty = new \Smarty();
		$this->smarty->error_reporting = E_ALL ^ E_NOTICE;
		$this->smarty->setCompileDir($smartyConfig->compilePath);
		$this->smarty->setCacheDir($smartyConfig->cachePath);
		$this->smarty->setConfigDir($smartyConfig->configPath);
		$this->smarty->setTemplateDir($smartyConfig->templatePath);
		//$this->smarty->debugging = true;
	} 
}

?>
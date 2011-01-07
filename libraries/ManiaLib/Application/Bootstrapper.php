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
 * Default bootstrapper
 */
abstract class Bootstrapper
{
	static function run($configFile = null, $configClass = '\ManiaLib\Config\Config')
	{
		error_reporting(E_ALL);
		set_error_handler(array('\ManiaLib\Application\ErrorHandling', 'exceptionErrorHandler'));
		
		try 
		{
			if(!$configFile)
			{
				$configFile = APP_PATH.'config/app.ini';
			}
			
			$loader = \ManiaLib\Config\Loader::getInstance();
			$loader->setConfigFilename($configFile);
			$loader->setConfigClassname($configClass);
			$loader->smartLoad();
			
			$loader = \ManiaLib\I18n\Loader::getInstance();
			$loader->smartLoad();
			
			try 
			{
				\ManiaLib\Application\Controller::dispatch();
			}
			catch(\Exception $exception)
			{
				ErrorHandling::exceptionHandler($exception);
			}
			
		}
		catch(\Exception $exception)
		{
			// Fallback fatal error log
			if(defined('APP_PATH'))
			{
				@file_put_contents(APP_PATH.'fatal_error.log', print_r($exception, true), FILE_APPEND);
			}
			echo '<manialink><timeout>0</timeout><label text="Fatal error" /></manialink>';
		}
	}
}

?>
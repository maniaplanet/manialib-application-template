<?php

abstract class ManiaLib_Application_Bootstrapper
{
	static function run($configFile, $configClass = 'ManiaLib_Config_Config')
	{
		error_reporting(E_ALL);
		set_error_handler(array('ManiaLib_Application_ErrorHandling', 'exceptionErrorHandler'));
		
		try 
		{
			$loader = ManiaLib_Config_Loader::getInstance();
			$loader->setConfigFilename($configFile);
			$loader->setConfigClassname($configClass);
			$loader->smartLoad();
			
			$loader = ManiaLib_I18n_Loader::getInstance();
			$loader->smartLoad();
			
			try 
			{
				ManiaLib_Application_Controller::dispatch();
			}
			catch(Exception $exception)
			{
				ManiaLib_Application_ErrorHandling::exceptionHandler($exception);
			}
			
		}
		catch(Exception $exception)
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
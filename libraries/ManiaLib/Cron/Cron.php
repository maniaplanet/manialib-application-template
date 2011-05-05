<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2961 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-03-14 16:22:46 +0100 (lun., 14 mars 2011) $:
 */
 
namespace ManiaLib\Cron;

use ManiaLib\Utils\Singleton;

abstract class Cron extends Singleton
{
	static $configFile;
	static $errorReporting = E_ALL;
	static $errorHandlingClass = '\ManiaLib\Application\ErrorHandling';
	static $errorHandler = 'exceptionErrorHandler';
	static $exceptionHandler = 'exceptionHandler';
	static $fatalExceptionHandler = 'fatalExceptionHandler';
	protected $sectionCount = 0;
	protected $output;
	
	abstract protected function onRun();
	
	final function run()
	{
		error_reporting(static::$errorReporting);
		set_error_handler(array(static::$errorHandlingClass, static::$errorHandler));
		
		$this->debug('Loading config...');
		try 
		{
			\ManiaLib\Config\Loader::$enableCache = false;
			$loader = \ManiaLib\Config\Loader::getInstance();
			$loader->setConfigFilename(static::$configFile);
			$loader->smartLoad();
		}
		catch (\Exception $e)
		{
			$this->debug('ERROR WHILE LOADING CONFIG.');
			$this->debug($e);
			exit;
		}
		$this->debug('OK');
		try 
		{
			$this->onRun();
		} 
		catch (\Exception $e) 
		{
			$this->debug('ERROR: %s', $e->getMessage());
			$this->debug('Error while executing cron. Exiting...');
			exit;
		}
		
	}
	
	final protected function debug($message)
	{
		$output = '';
		$output .= date('c').'    ';
		for($i=0; $i<$this->sectionCount; $i++)
		{
			$output .= '    ';
		}
		if(func_get_args() > 1)
		{
			$message = call_user_func_array('sprintf', func_get_args());
		}
		$output .= print_r($message, true);
		$output .= "\n";
		
		$this->output .= $output;
		echo $output;
	}
	
	final protected function separator()
	{
		$this->debug('----------------------------------------------------------------');
	}
	
	final protected function beginSection()
	{
		$this->sectionCount++;
	}
	
	final protected function endSection()
	{
		if($this->sectionCount)
		{
			$this->sectionCount--;
		}
	}
}

?>
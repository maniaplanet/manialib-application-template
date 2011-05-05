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
 * Error handling features
 */
abstract class ErrorHandling
{
	/**
	 * @ignore
	 */
	protected static $messageConfigs = array(
		'default' => array(
			'title'      => '%s',
			'simpleLine' => '    %s',
			'line'       => '    %s: %s'
		),
		'debug' => array(
			'title'      => '$<$ff0$o%s$>',
			'simpleLine' => '    %s',
			'line'       => '    $<$ff0%s$> :    %s'
		),
	);
	
	/**
	 * Error handler
	 * Converts PHP errors into ErrorException
	 * @throws ErrorException
	 */
	static function exceptionErrorHandler($errno, $errstr, $errfile, $errline) 
	{
    	if (!(error_reporting() & $errno)) 
    	{
        	// This error code is not included in error_reporting
        	return;
    	}
		throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
	}
	
	/**
	 * Exception handler
	 * Prints a nice error message in manialink
	 */
	static function exceptionHandler(\Exception $exception)
	{
		$request = Request::getInstance();
		$refererURL = $request->getReferer();
		$requestURI = Dispatcher::getInstance()->getCalledURL();
		$debug = \ManiaLib\Config\Config::getInstance()->debug;
		
		if($exception instanceof SilentUserException)
		{
			$message = static::computeShortMessage($exception).'  '.$requestURI;
			$userMessage = $exception->getMessage();
		}
		elseif($exception instanceof UserException)
		{
			$message = static::computeShortMessage($exception).'  '.$requestURI;
			\ManiaLib\Log\Logger::user($message);
			$userMessage = $exception->getMessage();
		}
		else
		{
			$requestURILine = sprintf(static::$messageConfigs['default']['line'], 'Request URI', $requestURI);			
			$message = static::computeMessage($exception, static::$messageConfigs['default'], array($requestURILine));
			\ManiaLib\Log\Logger::error($message);
			$userMessage = null;
		}
		
		$response = Response::getInstance();
		if($message)
		{
			$response->message = $debug ? $message : $userMessage;
		}
		if($debug)
		{
			$response->width = 126;
			$response->height = 94;
		}
		$response->backLink = $refererURL;
		$response->registerErrorView();
	}
	
	static function logException(\Exception $e)
	{
		$requestURI = Dispatcher::getInstance()->getCalledURL();
		$requestURILine = sprintf(static::$messageConfigs['default']['line'], 'Request URI', $requestURI);			
		$message = static::computeMessage($e, static::$messageConfigs['default'], array($requestURILine));
		\ManiaLib\Log\Logger::error($message);
	}
	
	/**
	 * Fallback exception handler when nothing works. 
	 * Just tries to dump the exception in a file at the app root and prints a 
	 * message.
	 */
	static function fatalExceptionHandler(\Exception $exception)
	{
		if(defined('APP_PATH'))
		{
			@file_put_contents(APP_PATH.'fatal-error.log', print_r($exception, true), FILE_APPEND);
		}
		if(array_key_exists('HTTP_USER_AGENT', $_SERVER) && $_SERVER['HTTP_USER_AGENT'] == 'GameBox')
		{
			echo '<manialink><timeout>0</timeout><label text="Fatal error." /></manialink>';
		}
		else
		{
			echo '<h1>Oops</h1>';
			echo '<p>An error occured. Please try again later.</p>';
			echo '<hr />';
			if(\ManiaLib\Config\Config::getInstance()->debug)
			{
				var_dump($exception);
			}
		}
	}
				
	/**
	 * Computes a human readable log message from any exception
	 * @return string
	 * @ignore
	 */
	final static function computeMessage(\Exception $e, $styles = array(), $additionalLines = array())
	{
		if(!$styles)
		{
			$styles = static::$messageConfigs['default'];
		}
		
		$trace = $e->getTraceAsString();
		$trace = explode("\n", $trace);
		foreach ($trace as $key=>$value)
		{
			$trace[$key] = sprintf($styles['simpleLine'], preg_replace('/#[0-9]*\s*/', '', $value));
		}
		$file = sprintf($styles['simpleLine'], $e->getFile().' ('.$e->getLine().')');
		
		$lines[] = sprintf($styles['title'], get_class($e));
		$lines[] = '';
		$lines[] = sprintf($styles['line'], 'Message', print_r($e->getMessage(), true));
		$lines[] = sprintf($styles['line'], 'Code', $e->getCode());
		$lines = array_merge($lines, $additionalLines, array($file), $trace);
		$lines[] = '';
		return implode("\n", $lines);
	}
	
	/**
	 * Computes a short human readable log message from any exception
	 * @return string
	 * @ignore
	 */
	final static function computeShortMessage(\Exception $e)
	{
		$message = get_class($e).'  '.$e->getMessage().' ('.$e->getCode().') in '.$e->getFile().' at line '.$e->getLine();
		return $message;
	}
	
	
}

?>
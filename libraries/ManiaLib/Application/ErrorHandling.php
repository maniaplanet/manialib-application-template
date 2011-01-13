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
    	throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
	}
	
	/**
	 * Exception handler
	 * Prints a nice error message in manialink
	 */
	static function exceptionHandler(\Exception $exception)
	{
		$request = \ManiaLib\Application\Request::getInstance();
		$requestURI = $request->createLink();
		
		if($exception instanceof \ManiaLib\Application\UserException)
		{
			$message = static::computeShortMessage($exception).'  '.$requestURI;
			\ManiaLib\Log\Logger::user($message);
			static::showErrorDialog($exception->getMessage());
		}
		else
		{
			$requestURILine = sprintf(static::$messageConfigs['default']['line'], 'Request URI', $requestURI);			
			$message = static::computeMessage($exception, static::$messageConfigs['default'], array($requestURILine));
			\ManiaLib\Log\Logger::error($message);
			
			if(\ManiaLib\Utils\Debug::isDebug())
			{
				$requestURILine = sprintf(static::$messageConfigs['debug']['line'], 'Request URI', $requestURI);
				$message = static::computeMessage($exception, static::$messageConfigs['debug'], array($requestURILine));
				static::showDebugDialog($message);
			}
			else
			{
				static::showErrorDialog();
			}
		}
	}
	
	/**
	 * Fallback exception handler when nothing works. 
	 * Just tries to dump the exception in a file at the app root and prints a 
	 * message.
	 */
	static function fatalExceptionHandler(\Exception $exception)
	{
		var_dump($exception);exit;
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
			echo 'Fatal error.';
		}
	}
	
	/**
	 * Shows an error dialog to the user with the specified message
	 * @param The message to show, default is 'Fatal error'
	 * @ignore
	 */
	static function showErrorDialog($message = 'Fatal error')
	{
		$request = \ManiaLib\Application\Request::getInstance();
		$linkstr = $request->getReferer();
		
		\ManiaLib\Gui\Manialink::load();
		{
			$ui = new \ManiaLib\Gui\Cards\Panel(70, 35);
			$ui->setAlign('center', 'center');
			$ui->title->setStyle(\ManiaLib\Gui\Elements\Label::TextTitleError);
			$ui->titleBg->setSubStyle(\ManiaLib\Gui\Elements\Bgs1::BgTitle2);
			$ui->title->setText('Error');
			$ui->save();

			$ui = new \ManiaLib\Gui\Elements\Label(68);
			$ui->enableAutonewline();
			$ui->setAlign('center', 'center');
			$ui->setPosition(0, 0, 2);
			$ui->setText($message);
			$ui->save();

			$ui = new \ManiaLib\Gui\Elements\Button;
			$ui->setText('Back');
			
			$ui->setManialink($linkstr);
			$ui->setPosition(0, -12, 5);
			$ui->setHalign('center');
			$ui->save();
		}
		\ManiaLib\Gui\Manialink::render();
		exit;
	}
	
	/**
	 * Error dialog for debug, the panel is bigger to fit the whole exception log
	 * @param The message to show, default is 'Fatal error'
	 * @ignore
	 */
	static function showDebugDialog($message = 'Fatal error')
	{
		$request = \ManiaLib\Application\Request::getInstance();
		$linkstr = $request->getReferer();
		
		\ManiaLib\Gui\Manialink::load();
		{
			$ui = new \ManiaLib\Gui\Cards\Panel(124, 92);
			$ui->setAlign('center', 'center');
			$ui->title->setStyle(\ManiaLib\Gui\Elements\Label::TextTitleError);
			$ui->titleBg->setSubStyle(\ManiaLib\Gui\Elements\Bgs1::BgTitle2);
			$ui->title->setText('Error');
			$ui->save();

			$ui = new \ManiaLib\Gui\Elements\Label(122);
			$ui->setAlign('left', 'top');
			$ui->setPosition(-60, 38, 2);
			$ui->enableAutonewline();
			$ui->setText(utf8_encode($message));
			$ui->save();

			$ui = new \ManiaLib\Gui\Elements\Button;
			$ui->setText('Back');
			
			$ui->setManialink($linkstr);
			$ui->setPosition(0, -40, 5);
			$ui->setHalign('center');
			$ui->save();
		}
		\ManiaLib\Gui\Manialink::render();
		exit;
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
		$message = get_class($e).'  '.$e->getMessage().'  ('.$e->getCode().')';
		return $message;
	}
	
	
}

?>
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
	 * Converts standard PHP errors into ErrorException
	 * Usage (loaded by default in the MVC framework):
	 * <code>
	 * set_error_handler(array('ErrorHandling', 'exceptionErrorHandler'));
	 * </code>
	 * @throws ErrorException
	 */
	static function exceptionErrorHandler($errno, $errstr, $errfile, $errline) 
	{
    	throw new \ErrorException($errstr, 0, $errno, $errfile, $errline);
	}
	
	/**
	 * Exception handler
	 * Used to cleanly catch exceptions, and is also used as uncaught exception handler.
	 * Prints a nice error message in manialink
	 * Usage for catching exceptions:
	 * <code>
	 * try
	 * {
	 *     //...
	 * }
	 * catch(\Exception $exception)
	 * {
	 *     ErrorHandling::exceptionHandler($exception);
	 * }
	 * </code>
	 * Usage for default exception handling:
	 * <code>
	 * set_exception_handler(array('ErrorHandling', 'exceptionHandler'));
	 * </code>
	 * Note: the MVC framework uses both by default
	 */
	static function exceptionHandler(\Exception $exception)
	{
		$request = \ManiaLib\Application\Request::getInstance();
		$requestURI = $request->createLink();
		
		if($exception instanceof \ManiaLib\Application\UserException)
		{
			$message = self::computeShortMessage($exception).'  '.$requestURI;
			\ManiaLib\Log\Logger::user($message);
			self::showErrorDialog($exception->getMessage());
		}
		else
		{
			$requestURILine = sprintf(self::$messageConfigs['default']['line'], 'Request URI', $requestURI);			
			$message = self::computeMessage($exception, self::$messageConfigs['default'], array($requestURILine));
			\ManiaLib\Log\Logger::error($message);
			
			if(\ManiaLib\Utils\Debug::isDebug())
			{
				$requestURILine = sprintf(self::$messageConfigs['debug']['line'], 'Request URI', $requestURI);
				$message = self::computeMessage($exception, self::$messageConfigs['debug'], array($requestURILine));
				self::showDebugDialog($message);
			}
			else
			{
				self::showErrorDialog();
			}
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
	static protected function computeMessage(\Exception $e, array $styles, array $additionalLines = array())
	{
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
	static protected function computeShortMessage(\Exception $e)
	{
		$message = get_class($e).'  '.$e->getMessage().'  ('.$e->getCode().')';
		return $message;
	}
	
	
}

?>
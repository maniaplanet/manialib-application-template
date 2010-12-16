<?php
/**
 * Error handling features
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

abstract class ManiaLib_Application_ErrorHandling
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
    	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
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
	 * catch(Exception $exception)
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
	static function exceptionHandler(Exception $exception)
	{
		$request = ManiaLib_Application_Request::getInstance();
		$requestURI = $request->createLink();
		
		if($exception instanceof ManiaLib_Application_UserException)
		{
			$message = self::computeShortMessage($exception).'  '.$requestURI;
			ManiaLib_Log_Logger::user($message);
			self::showErrorDialog($exception->getMessage());
		}
		else
		{
			$requestURILine = sprintf(self::$messageConfigs['default']['line'], 'Request URI', $requestURI);			
			$message = self::computeMessage($exception, self::$messageConfigs['default'], array($requestURILine));
			ManiaLib_Log_Logger::error($message);
			
			if(ManiaLib_Utils_Debug::isDebug())
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
		$request = ManiaLib_Application_Request::getInstance();
		$linkstr = $request->getReferer();
		
		ManiaLib_Gui_Manialink::load();
		{
			$ui = new ManiaLib_Gui_Cards_Panel(70, 35);
			$ui->setAlign('center', 'center');
			$ui->title->setStyle(ManiaLib_Gui_Elements_Label::TextTitleError);
			$ui->titleBg->setSubStyle(ManiaLib_Gui_Elements_Bgs1::BgTitle2);
			$ui->title->setText('Error');
			$ui->save();

			$ui = new ManiaLib_Gui_Elements_Label(68);
			$ui->enableAutonewline();
			$ui->setAlign('center', 'center');
			$ui->setPosition(0, 0, 2);
			$ui->setText($message);
			$ui->save();

			$ui = new ManiaLib_Gui_Elements_Button;
			$ui->setText('Back');
			
			$ui->setManialink($linkstr);
			$ui->setPosition(0, -12, 5);
			$ui->setHalign('center');
			$ui->save();
		}
		ManiaLib_Gui_Manialink::render();
		exit;
	}
	
	/**
	 * Error dialog for debug, the panel is bigger to fit the whole exception log
	 * @param The message to show, default is 'Fatal error'
	 * @ignore
	 */
	static function showDebugDialog($message = 'Fatal error')
	{
		$request = ManiaLib_Application_Request::getInstance();
		$linkstr = $request->getReferer();
		
		ManiaLib_Gui_Manialink::load();
		{
			$ui = new ManiaLib_Gui_Cards_Panel(124, 92);
			$ui->setAlign('center', 'center');
			$ui->title->setStyle(ManiaLib_Gui_Elements_Label::TextTitleError);
			$ui->titleBg->setSubStyle(ManiaLib_Gui_Elements_Bgs1::BgTitle2);
			$ui->title->setText('Error');
			$ui->save();

			$ui = new ManiaLib_Gui_Elements_Label(122);
			$ui->setAlign('left', 'top');
			$ui->setPosition(-60, 38, 2);
			$ui->enableAutonewline();
			$ui->setText(utf8_encode($message));
			$ui->save();

			$ui = new ManiaLib_Gui_Elements_Button;
			$ui->setText('Back');
			
			$ui->setManialink($linkstr);
			$ui->setPosition(0, -40, 5);
			$ui->setHalign('center');
			$ui->save();
		}
		ManiaLib_Gui_Manialink::render();
		exit;
	}
				
	/**
	 * Computes a human readable log message from any exception
	 * @return string
	 * @ignore
	 */
	static protected function computeMessage(Exception $e, array $styles, array $additionalLines = array())
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
	static protected function computeShortMessage(Exception $e)
	{
		$message = get_class($e).'  '.$e->getMessage().'  ('.$e->getCode().')';
		return $message;
	}
	
	
}

?>
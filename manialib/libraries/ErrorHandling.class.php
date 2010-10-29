<?php
/**
 * Error handling features
 * 
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 * @subpackage ErrorHandling
 */

/**
 * Error handling features
 * @package ManiaLib
 * @subpackage ErrorHandling
 * @ignore
 */
abstract class ErrorHandling
{
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
	 * Exception handler
	 * Converts standard PHP errors into ErrorException
	 * @throws ErrorException
	 */
	static function exceptionErrorHandler($errno, $errstr, $errfile, $errline) 
	{
    	throw new ErrorException($errstr, 0, $errno, $errfile, $errline);
	}
	
	/**
	 * Default exception handler
	 * Prints a nice error page and logs the exception
	 * Also act as the uncaught exception handler
	 */
	static function exceptionHandler(Exception $exception)
	{
		// FIXME exception handling catch some exceptions to show a better message
		
		$message = self::computeMessage($exception, self::$messageConfigs['default']);
		Debug::log($message, Debug::LOG_DATE, APP_ERROR_LOG);
		
		if(APP_DEBUG_LEVEL)
		{
			$message = self::computeMessage($exception, self::$messageConfigs['debug']);
			self::showDebugDialog($message);
		}
		else
		{
			self::showErrorDialog();
		}
	}
	
	/**
	 * Shows an error dialog to the user with the specified message
	 * @param The message to show, default is 'Fatal error'
	 * @ignore
	 */
	static function showErrorDialog($message = 'Fatal error')
	{
		$request = call_user_func(array(APP_FRAMEWORK_REQUEST_ENGINE_CLASS, 'getInstance'));
		$linkstr = $request->getReferer();
		
		Manialink::load();
		{
			$ui = new Panel(70, 35);
			$ui->setAlign('center', 'center');
			$ui->title->setStyle(Label::TextTitleError);
			$ui->titleBg->setSubStyle(Bgs1::BgTitle2);
			$ui->title->setText('Error');
			$ui->save();

			$ui = new Label(68);
			$ui->enableAutonewline();
			$ui->setAlign('center', 'center');
			$ui->setPosition(0, 0, 2);
			$ui->setText($message);
			$ui->save();

			$ui = new Button;
			$ui->setText('Back');
			
			$ui->setManialink($linkstr);
			$ui->setPosition(0, -12, 5);
			$ui->setHalign('center');
			$ui->save();
		}
		Manialink::render();
		exit;
	}
	
	/**
	 * Error dialog for debug, the panel is bigger to fit the whole exception log
	 * @param The message to show, default is 'Fatal error'
	 * @ignore
	 */
	static function showDebugDialog($message = 'Fatal error')
	{
		$request = call_user_func(array(APP_FRAMEWORK_REQUEST_ENGINE_CLASS, 'getInstance'));
		$linkstr = $request->getReferer();
		
		Manialink::load();
		{
			$ui = new Panel(124, 92);
			$ui->setAlign('center', 'center');
			$ui->title->setStyle(Label::TextTitleError);
			$ui->titleBg->setSubStyle(Bgs1::BgTitle2);
			$ui->title->setText('Error');
			$ui->save();

			$ui = new Label(122);
			$ui->setAlign('left', 'top');
			$ui->setPosition(-60, 38, 2);
			$ui->enableAutonewline();
			$ui->setText(utf8_encode($message));
			$ui->save();

			$ui = new Button;
			$ui->setText('Back');
			
			$ui->setManialink($linkstr);
			$ui->setPosition(0, -40, 5);
			$ui->setHalign('center');
			$ui->save();
		}
		Manialink::render();
		exit;
	}
				
	/**
	 * Computes a human readable message from any exception
	 * Usefull for logging and displaying when in debug mode
	 * @return string
	 * @ignore
	 */
	static protected function computeMessage(Exception $e, array $styles)
	{
		$lines[] = sprintf($styles['title'], get_class($e));
		$lines[] = '';
		$lines[] = sprintf($styles['line'], 'Message', print_r($e->getMessage(), true));
		$lines[] = sprintf($styles['line'], 'Code', $e->getCode());
		$lines[] = sprintf($styles['simpleLine'], $e->getFile().' ('.$e->getLine().')');
		foreach($e->getTrace() as $t)
		{
			$lines[] = sprintf($styles['simpleLine'], 
				$t['file'].
				' ('.$t['line'].'): '.
				$t['function']).'('.
				(array_key_exists('args', $t) ? implode(', ', $t['args']) : '').
				')';
		}
		$lines[] = '';
		 
		return implode("\n", $lines);
	}
	
	
}

?>
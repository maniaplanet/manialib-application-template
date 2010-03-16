<?php
/**
 * Error handling
 * 
 * @author Maxime Raoust
 * @package Manialib
 */

/**
 * HOW TO USE THE ERROR HANDLERS :
 * 
 * If DEBUG_LEVEL > 0 all messages are shown to the user
 * 
 * trigger_error('A message');
 * Prints the error message to the user and log it
 * 
 * trigger_error('A message', E_USER_ERROR)
 * Prints "Internal error" to the user and log the message
 * 
 * trigger_error('A message', E_USER_WARNING)
 * Log the warning message and continue script execution
 * 
 */

/**
 * Error handling class
 */
abstract class ErrorHandling
{
	/**
	 * Default handler
	 */
	static function manialinkHandler($errno, $errstr, $errfile, $errline)
	{
		self::logMessage($errno, $errstr, $errfile, $errline);
		self::filterMessage($errno, $errstr);
		
		switch($errno)
		{
			case E_NOTICE:
			case E_USER_NOTICE:
			case E_ERROR:
			case E_USER_ERROR:
				$request = RequestEngine::getInstance();
				$session = SessionEngine::getInstance();
				$linkstr = $request->getReferer();
				
				Manialink::load();
				{
					$ui = new Panel(70, 35);
					$ui->setAlign('center', 'center');
					$ui->title->setStyle('TextTitleError');
					$ui->titleBg->setSubStyle('BgTitle2');
					$ui->title->setText('Error');
					$ui->save();
		
					$ui = new Label(68);
					$ui->enableAutonewline();
					$ui->setAlign('center', 'center');
					$ui->setPosition(0, 0, 2);
					$ui->setText($errstr);
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
	}
	
	static function exceptionHandler($exception)
	{
		trigger_error(
			'Uncaught exception: ' . print_r($exception, true), 
			E_USER_ERROR);
	}
	
	/**
	 * Log the message with the right format and tag
	 */
	static private function logMessage($errno, &$errstr, $errfile, $errline, $forcelog = null)
	{
		switch($errno)
		{
			case E_WARNING:      $errorName = 'Warning';       break;
			case E_USER_WARNING: $errorName = 'User Warning';  break;
			case E_NOTICE:       $errorName = 'Notice';        break;
			case E_USER_NOTICE:  $errorName = 'User Notice';   break;
			case E_ERROR:        $errorName = 'Error';         break;
			case E_USER_ERROR:   $errorName = 'User Error';    break;
			default:             $errorName = 'Error n° ' .$errno . ']';
		}
		
		if(!$forcelog)
		{
			switch($errno)
			{
				case E_USER_WARNING:
				case E_USER_NOTICE:
					$log = APP_DEBUG_LOG;
					break;
				default:
					$log = APP_ERROR_LOG;
			}
		}
		else
		{
			$log = $forcelog;
		}
		
		$request = RequestEngine::getInstance();
		
		$debugMessage = 
			date('d/m/y H:i:s') . ' ['.$errorName.'] '.
			'' . $errstr . ' ' .
			'at url ' . $request->createLink() . ' ' .
			'in file ' . $errfile . ' ' .
			'on line ' . $errline . ' ' . "\n";
		error_log($debugMessage, 3, $log);
		
		if(DEBUG_LEVEL >= DEBUG_ON)
		{
			$errstr =
				date('d/m/y H:i:s') . ' $<$o['.$errorName.']$> '.
				'$<$0f0' . $errstr . '$> ' .
				'at url $<$ff0' . $request->createLink() . '$> ' .
				'in file $<$ff0' . $errfile . '$> ' .
				'on line $<$ff0' . $errline . '$>' . "\n";
		}
	}
	
	/**
	 * Filter the message before being printed to the user 
	 */
	static private function filterMessage($errno, &$errstr)
	{
		if(DEBUG_LEVEL > 0)
		{
			return;
		}
		
		switch($errno)
		{
			case E_USER_WARNING:
			case E_USER_NOTICE:
				return;
			
			default:
				$errstr = 'internal_error';
				return;
		}
	}
}

?>
<?php
/**
 * Error handling
 * 
 * @author Maxime Raoust
 * @package Manialib
 */

/**
 * Error handling class
 */
abstract class ErrorHandling
{
	/**
	 * Shows an error dialog to the user with the specified message
	 * @param The message to show, default is 'Fatal error'
	 */
	static function showErrorDialog($message='Fatal error')
	{
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
	 * Exception handler: transforms standard PHP errors into
	 * FrameworkErrorException
	 */
	static function exceptionErrorHandler($errno, $errstr, $errfile, $errline) 
	{
    	switch($errno)
    	{
    		case E_USER_WARNING:
    			debuglog('Warning: '.$errstr.' in '.$errfile.':'.$errline);
    			break;
    		
    		default:
    			throw new FrameworkErrorException(
    				$errstr, 0, $errno, $errfile, $errline);
    	}
	}
	
	/**
	 * Uncaught exceptions handler
	 */
	static function exceptionHandler($exception)
	{
		if($exception instanceof FrameworkException)
		{
			try
			{
				throw new FrameworkUncaughtException($exception);
			}
			catch(FrameworkException $e)
			{
				self::showErrorDialog($e);
			}
		}
		// Assert
		else
		{
			Manialink::load();
			$ui = new Label;
			$ui->setText('uncaught exception');
			$ui->save();
			Manialink::render();
			exit;
		}
	}
}

?>
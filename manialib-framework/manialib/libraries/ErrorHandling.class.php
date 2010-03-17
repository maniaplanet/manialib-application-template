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
	 * Exception handler: transforms standard PHP errors into
	 * FrameworkErrorException
	 */
	static function exceptionErrorHandler($errno, $errstr, $errfile, $errline) 
	{
    	// TODO Do not throw FrameworkErrorException when the error level is low
    	throw new FrameworkErrorException($errstr, 0, $errno, $errfile, $errline);
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
				$e->showErrorDialog();
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
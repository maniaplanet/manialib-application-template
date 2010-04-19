<?php
/**
 * @author Maxime Raoust
 */

/**
 * Error handling
 * @package Manialib
 */
abstract class ErrorHandling
{
	/**
	 * Exception handler: transforms standard PHP errors into
	 * FrameworkErrorException
	 */
	static function exceptionErrorHandler($errno, $errstr, $errfile, $errline) 
	{
    	switch($errno)
    	{
    		case E_USER_WARNING:
    			new FrameworkException($errstr);
    			break;
    		
    		default:
    			// Hack: sometimes classes can't be loaded throuh __autoload
    			require_once(APP_FRAMEWORK_EXCEPTIONS_PATH.'FrameworkErrorException.class.php');
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
			FrameworkException::handle($exception);
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
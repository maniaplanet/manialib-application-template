<?php
/**
 * @author Maxime Raoust
 * @package Manialib
 */

/**
 * The framework's default exception
 */
class FrameworkException extends Exception 
{
	protected $requestURL;
	protected $dateThrown;
	protected $logMessage;
	protected $optionalMessageLabel;
	protected $optionalMessageContent;
	
	/**
	 * Handles what to do when an exception is catched.
	 * @param Exception
	 */
	static function handle(Exception $e)
	{
		if($e instanceof FrameworkUserException)
		{
			ErrorHandling::showErrorDialog($e->getMessage());
		}
		if($e instanceof FrameworkException)
		{
			ErrorHandling::showErrorDialog();
		}
		else
		{
			$ie = new FrameworkImportedException($e);
			ErrorHandling::showErrorDialog();
		}
	}
	
	/**
	 * Logs an exception
	 * @param Exception 
	 * @param string The label of the optional message
	 * @param string An optional message that will be logged with the exception
	 * (eg: usefull to log Mysql queries in database exceptions)
	 */
	static function logException(Exception $e, $optionalMessageLabel=null,
		$optionalMessageContent=null)
	{
		// Message config
		$spacerPrefix = '    ';
		$charPrefix = '# ';
		$prefix = $spacerPrefix.$charPrefix;
		$padLendth = 15;
		
		// Request URL if it exists
		$requestURL = 
			method_exists($e, 'getRequestURL') ?
			$prefix.str_pad('Request:', $padLendth).$e->getRequestURL()."\n" : 
			'';
			
		// optionnal message if it exists	
		$optionalMessage = 
			$optionalMessageLabel ?
			$prefix.str_pad($optionalMessageLabel.':', $padLendth)."\n" :
			'';
		
		// The message itself
		$message = 
			get_class($e) ."\n".
			$prefix.str_pad('Date:', $padLendth).date('d/m/y H:i:s') ."\n".
			$prefix.str_pad('Message:', $padLendth).
			print_r($e->getMessage(), true).' ('.$e->getCode().')' ."\n".
			$optionalMessage .
			$requestURL .
			$prefix.str_pad('File:', $padLendth).
			$e->getFile().':'.$e->getLine() ."\n".
			$prefix.str_pad('Backtrace:', $padLendth)."\n".
			$spacerPrefix. 
			str_replace("\n", "\n".$spacerPrefix, $e->getTraceAsString())
			."\n"."\n";

		return $message;
	}

	/**
	 * Default constructor
	 * @param string The Exception message to throw
	 * @param int The Exception code
	 * @param Exception The previous exception used for the exception chaining
	 * (since PHP 5.3, used here for forward compatibility)
	 * @param boolean Whether you want to log the exception or not (useful to
	 * modify the log message in subclasses)
	 */	
	function __construct($message='', $code=0, Exception $previous=null, $logException=true)
	{
		parent::__construct($message, $code);

		$request = RequestEngine::getInstance();
		$this->dateThrown = time();
		$this->requestURL = $request->createLink();
		if($logException)
		{
			$this->iLog();			
		}
	}
	
	/**
	 * Returns the URL of the request in which the Exception was thrown
	 * @return string
	 */
	function getRequestURL()
	{
		return $this->requestURL;
	}
	
	/**
	 * Returns the UNIX timestamp when the exception was thrown
	 * @return int
	 */
	function getDateThrown()
	{
		return $this->dateThrown;
	}
	
	/**
	 * Returns the label of the optional message
	 * @return string
	 */
	function getOptionalMessageLabel()
	{
		return $this->optionalMessageLabel;
	}
	
	/**
	 * Returns the content of the optional message
	 * @return srting
	 */
	function getOptionalMessage()
	{
		return $this->optionalMessageContent;
	}
	
	/**
	 * Logs the exception in the specified log file.
	 * @param string The log file. Default is APP_ERROR_LOG
	 */
	function iLog($logfile=APP_ERROR_LOG)
	{
		if(!$this->logMessage)
		{
			$this->logMessage = self::logException($this);
		}
		file_put_contents($logfile, $this->logMessage, FILE_APPEND);
	}
}

?>
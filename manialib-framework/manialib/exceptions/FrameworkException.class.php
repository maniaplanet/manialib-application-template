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
	/**#@+
	 * Parameters for self::handle()
	 */
	const HANDLE_SHOW_ERRORS = true;
	const HANDLE_SILENT = false;
	/**#@-*/
	
	
	/**
	 * Message to display to the user
	 */
	protected $userMessage='An error occured';
	
	protected $requestURL;
	protected $dateThrown;
	protected $logMessage;
	protected $optionalMessageLabel;
	protected $optionalMessageContent;
	
	/**
	 * Shows an error dialog to the user with the specified message
	 * @param The message to show, default is 'Fatal error'
	 */
	static function showErrorDialog($message = 'Fatal error')
	{
		$request = RequestEngine::getInstance();
		$session = SessionEngine::getInstance();
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
	 * Handles what to do when an exception is catched.
	 * @param Exception
	 * @param boolean Whether to show an error message, default is true
	 */
	static function handle(Exception $e, 
		$showErrorMessage=self::HANDLE_SHOW_ERRORS)
	{
		if($e instanceof FrameworkException)
		{
			if($showErrorMessage)
			{
				self::showErrorDialog($e->getUserMessage());
			}
		}
		else
		{
			$ie = new FrameworkImportedException($e);
			if($showErrorMessage)
			{
				self::showErrorDialog();
			}
		}
	}
	
	/**
	 * Logs an exception (useful for foreign exceptions)
	 * @param Exception 
	 * @param string The log filename
	 */
	static function logException(Exception $e, $logfile=APP_ERROR_LOG)
	{
		file_put_contents($logfile, 
			self::getExceptionLogMessage($e), FILE_APPEND);
	}
	
	/**
	 * Returns the exception log message
	 * @param Exception 
	 * @param string The label of the optional message
	 * @param string An optional message that will be logged with the exception
	 * (eg: usefull to log Mysql queries in database exceptions)
	 * @return string
	 */
	static function getExceptionLogMessage(Exception $e, $optionalMessageLabel=null,
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
			$prefix.str_pad($optionalMessageLabel.':', $padLendth).
			$optionalMessageContent."\n" 
			: '';
		
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
	 * Returns the message to display to the user
	 * @return string
	 */
	function getUserMessage()
	{
		return $this->userMessage;
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
			$this->logMessage = self::getExceptionLogMessage($this, 
				$this->optionalMessageLabel, $this->optionalMessageContent);
		}
		file_put_contents($logfile, $this->logMessage, FILE_APPEND);
	}
}

?>
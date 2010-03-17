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
	
	function __construct($message='', $code=0)
	{
		parent::__construct($message, $code);
		
		$request = RequestEngine::getInstance();
		$this->dateThrown = time();
		$this->requestURL = $request->createLink();

		$this->logMessage =
			get_class($this) ."\n".
			'    # Date:      '. date('d/m/y H:i:s') ."\n".
			'    # Message:   '. print_r($this->message, true).' ('.$this->code.')' ."\n".
			'    # Request:   '. $this->requestURL ."\n".
			'    # File:      '. $this->file.':'.$this->line ."\n".
			'    # Backtrace: ' ."\n".
			'    ' . str_replace("\n", "\n    ", $this->getTraceAsString()) ."\n".
			"\n";

		$this->iLog();
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
	 * Logs the exception in the specified log file.
	 * @param string The log file. Default is APP_ERROR_LOG
	 */
	function iLog($logfile=APP_ERROR_LOG)
	{
		file_put_contents($logfile, $this->logMessage, FILE_APPEND);
	}
	
	/**
	 * Shows an error dialog to the user with the specified message
	 * @param The message to show, defaukt is 'Fatal error'
	 */
	function showErrorDialog($message='Fatal error')
	{
		$request = RequestEngine::getInstance();
		$session = SessionEngine::getInstance();
		$linkstr = $request->getReferer();
		
		// TODO Put the manialink error dialog code in an included file
		
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
}

?>
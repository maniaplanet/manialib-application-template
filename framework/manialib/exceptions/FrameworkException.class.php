<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 * @subpackage ErrorHandling
 */

/**
 * Framework default exception
 */
class FrameworkException extends Exception 
{
	/**#@+
	 * Parameters for self::handle()
	 */
	const HANDLE_SHOW_ERRORS = true;
	const HANDLE_SILENT = false;
	/**#@-*/

	protected $userMessage='An error occured';
	protected $requestURL;
	protected $optionalInfo;
	
	/**
	 * Shows an error dialog to the user with the specified message
	 * @param The message to show, default is 'Fatal error'
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
	 * Default exception handler
	 * 
	 * Handles what to do when an exception is catched
	 * @param Exception
	 * @param boolean Whether to show an error message, default is true
	 */
	static function handle(Exception $e, 
		$showErrorMessage=self::HANDLE_SHOW_ERRORS)
	{
		if(!($e instanceof FrameworkException))
		{
			$e_old = $e;
			$e = new FrameworkImportedException($e);
		}
		if($showErrorMessage)
		{
			if(APP_DEBUG_LEVEL == DEBUG_ON)
			{
				$message = FrameworkException::getDebugMessage($e, $e->getOptionalInfo());
				if(isset($e_old))
				{
					$message .= FrameworkException::getDebugMessage($e_old);
				}
				self::showDebugDialog($message);
			}
			else
			{
				$message = $e->getUserMessage();
				self::showErrorDialog($message);
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
		$message = self::getLogMessage($e);
		file_put_contents($logfile, $message, FILE_APPEND);
	}
		
	/**
	 * Computes the log message of any exception
	 * @param Exception
	 * @param array Additional info to log
	 * @return string
	 */
	static function getLogMessage(Exception $e, array $optionalInfo = array())
	{
		// Message config
		$styles = array(
			'valuePrefix' => '',
			'valueSuffix' => '',
			'titleStyle' => '',
			'optionalInfoLabelStyle' => '',
			'optionalInfoContentStyle' => '',
			'spacerPrefix' => '    ',
			'charPrefix' => '# ',
			'padLendth' => 15,
		);
		return self::computeLogMessage($e,$optionalInfo,$styles);
	}
	
	static function getDebugMessage(Exception $e, array $optionalInfo = array())
	{
		// Message config
		$styles = array(
			'valuePrefix' => '$<',
			'valueSuffix' => '$>',
			'titleStyle' => '$o$ff0',
			'optionalInfoLabelStyle' => '$ff0',
			'optionalInfoContentStyle' => '',
			'spacerPrefix' => '    ',
			'charPrefix' => '# ',
			'padLendth' => 25,
		);
		return self::computeLogMessage($e,$optionalInfo,$styles);
	}
	
	/**
	 * Computes the log message 
	 * @return string
	 */
	static protected function computeLogMessage(Exception $e, 
		array $optionalInfo, array $styles)
	{
		// Message config
		$valuePrefix = $styles['valuePrefix'];
		$valueSuffix = $styles['valueSuffix'];
		$titleStyle = $styles['titleStyle'];
		$optionalInfoLabelStyle = $styles['optionalInfoLabelStyle'];
		$optionalInfoContentStyle = $styles['optionalInfoContentStyle'];
		$spacerPrefix = $styles['spacerPrefix'];
		$charPrefix = $styles['charPrefix'];
		$padLendth = $styles['padLendth'];
		
		$prefix = $spacerPrefix.$charPrefix;
		
		// Computes the info		
		$LogInfo = array();
		
		$LogInfo['Date'] = date('d/m/y H:i:s');
		$LogInfo['Message'] = print_r($e->getMessage(), true).' ('.$e->getCode().')';
		
		$optionalInfo = (array) $optionalInfo;
		foreach($optionalInfo as $Key=>$Value)
		{
			$LogInfo[$Key] = $Value;
		}
		
		$LogInfo['File'] = $e->getFile().':'.$e->getLine();
		$LogInfo['Backtrace'] = 
			"\n".$spacerPrefix. 
			str_replace("\n", "\n".$spacerPrefix, $e->getTraceAsString());
		
		// Computes the message
		$Message = $valuePrefix.$titleStyle.get_class($e).$valueSuffix."\n";
		foreach($LogInfo as $Label=>$Content)
		{
			$Message .= 
				$prefix.str_pad(
				$valuePrefix.$optionalInfoLabelStyle.$Label.$valueSuffix.':', $padLendth).' '.
				$valuePrefix.$optionalInfoContentStyle.$Content.$valueSuffix."\n";
		}
		$Message .= "\n\n";

		return $Message;
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
		$request = call_user_func(array(APP_FRAMEWORK_REQUEST_ENGINE_CLASS, 'getInstance'));
		$this->requestURL = $request->createLink();
		$this->addOptionalInfo('User message', $this->userMessage);
		$this->addOptionalInfo('Request URL', $this->requestURL);
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
	 * Adds an optional message to the exception log 
	 */
	function addOptionalInfo($label, $content)
	{
		$this->optionalInfo[$label] = $content;
	}
	
	/**
	 * Returns the optional info
	 * @return array
	 */
	function getOptionalInfo()
	{
		return (array) $this->optionalInfo;
	}
	
	/**
	 * Logs the exception in the specified log file.
	 * @param string The log file. Default is APP_ERROR_LOG
	 */
	function iLog($logfile=APP_ERROR_LOG)
	{
		$message = self::getLogMessage($this,$this->optionalInfo);
		file_put_contents($logfile, $message, FILE_APPEND);
	}
}

?>
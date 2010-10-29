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
			'valuePrefix'              => '',
			'valueSuffix'              => '',
			'titleStyle'               => '',
			'optionalInfoLabelStyle'   => '',
			'optionalInfoContentStyle' => '',
			'spacerPrefix'             => '    ',
			'charPrefix'               => '# ',
			'padLendth'                => 15,
		),
		'debug' => array(
			'valuePrefix'              => '$<',
			'valueSuffix'              => '$>',
			'titleStyle'               => '$o$ff0',
			'optionalInfoLabelStyle'   => '$ff0',
			'optionalInfoContentStyle' => '',
			'spacerPrefix'             => '    ',
			'charPrefix'               => '# ',
			'padLendth'                => 25,
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
		// TODO exceptionHandler: log some exceptions
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
		$logInfo = array();
		$logInfo['Date'] = date('d/m/y H:i:s');
		$logInfo['Message'] = print_r($e->getMessage(), true).' ('.$e->getCode().')';		
		$logInfo['File'] = $e->getFile().':'.$e->getLine();
		$logInfo['Backtrace'] = 
			"\n".$spacerPrefix. 
			str_replace("\n", "\n".$spacerPrefix, $e->getTraceAsString());
		
		// Computes the message
		$message = $valuePrefix.$titleStyle.get_class($e).$valueSuffix."\n";
		foreach($logInfo as $Label=>$Content)
		{
			$message .= 
				$prefix.str_pad(
				$valuePrefix.$optionalInfoLabelStyle.$Label.$valueSuffix.':', $padLendth).' '.
				$valuePrefix.$optionalInfoContentStyle.$Content.$valueSuffix."\n";
		}
		$message .= "\n\n";
		return $message;
	}
	
	
}

?>
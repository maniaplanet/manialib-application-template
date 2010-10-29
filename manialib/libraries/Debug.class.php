<?php 
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/** 
 * Debug methods
 * @package ManiaLib
 * @subpackage Helpers
 */ 
abstract class Debug
{
	const LOG_DATE = true;
	const LOG_NO_DATE = false;
	
	/**
	 * Writes a message in the debug log
	 * @param string The message
	 * @param boolean Whether to add the date to the message
	 * @param string The log filename
	 */
	static function log($message, $addDate = self::LOG_DATE, $logFilename = APP_DEBUG_LOG)
	{
		$message = ($addDate?date('c'):'').'  '.print_r($message, true)."\n";
		file_put_contents($logFilename, $message, FILE_APPEND);
	}
	
	/**
	 * FOOBAR!
	 * Dump the message in the Manialink explorer, only available when DEBUG_LEVEL is 1
	 */
	static function foobar($message)
	{
		// TODO Debug::foobar refaire
	}
}

?>
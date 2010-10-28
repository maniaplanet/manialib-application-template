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
	/**
	 * Writes a message in the debug log
	 * @param string The message
	 * @param boolean Whether to add the date to the message
	 * @param string The log filename
	 */
	static function log($message, $addDate = true, $logFilename = APP_DEBUG_LOG)
	{
		$message = ($addDate?date('d/m/y H:i:s'):'').'  '.print_r($message, true)."\n";
		file_put_contents($logFilename, $message, FILE_APPEND);
	}
	
	/**
	 * FOOBAR!
	 * Dump the message in the Manialink explorer, only available when DEBUG_LEVEL is 1
	 */
	static function foobar($message)
	{
		throw new DebugException(print_r($message, true));
	}
}

?>
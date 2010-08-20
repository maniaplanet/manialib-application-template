<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * Exception to handle generic user error
 * 
 * Eg. when a user enter a bad pararmeter in a form. The log of this type of 
 * exception is less verbose, and they are logged sepparately in APP_USER_ERROR_LOG
 * 
 * @package ManiaLib
 * @subpackage ErrorHandling
 */
class FrameworkUserException extends FrameworkException 
{
	/**
	 * @param string The message to display to the user
	 */
	function __construct($userMessage)
	{
		parent::__construct($userMessage, 0, null, false);
		$this->userMessage = $userMessage;
		$this->iLog(APP_USER_ERROR_LOG);
		debuglog('User error: '.$userMessage);
	} 
}

?>
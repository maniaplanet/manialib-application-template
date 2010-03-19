<?php
/**
 * @author Maxime Raoust
 * @package Manialib
 */

/**
 * Exception to handle generic user error
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
		$this->iLog(APP_DEBUG_LOG);
	} 
}

?>
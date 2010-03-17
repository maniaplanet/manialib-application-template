<?php
/**
 * @author Maxime Raoust
 * @package Manialib
 */

/**
 * Request exception
 */
class RequestParameterNotFoundException extends RequestException 
{
	function showErrorDialog()
	{
		parent::showErrorDialog('You must specify "'.$this->message.'"');
	}
}

?>
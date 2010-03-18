<?php
/**
 * @author Maxime Raoust
 * @package Manialib
 */

/**
 * Request exception
 */
class RequestParameterNotFoundException extends FrameworkUserException 
{
	function __construct($parameterName)
	{
		parent::__construct('You must specify $<$o'.$parameterName.'$>', 
			0, null, false);
		$this->iLog();
	}
}

?>
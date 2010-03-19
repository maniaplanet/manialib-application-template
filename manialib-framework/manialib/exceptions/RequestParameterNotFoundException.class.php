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
	/**
	 * @param string Human readable name of the parameter that was forgotten
	 */
	function __construct($parameterName)
	{
		parent::__construct('You must specify $<$o'.$parameterName.'$>', 
			0, null, false);
		$this->iLog();
	}
}

?>
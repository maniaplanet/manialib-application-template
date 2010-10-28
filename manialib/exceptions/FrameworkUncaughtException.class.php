<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * Exception for uncaught exceptions
 * 
 * @package ManiaLib
 * @subpackage ErrorHandling
 * @ignore
 */
class FrameworkUncaughtException extends FrameworkException
{
	function __construct(FrameworkException $uncaughtException)
	{
		parent::__construct('Uncaught '.get_class($uncaughtException));
	}
}

?>
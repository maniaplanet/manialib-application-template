<?php
/**
 * @author Maxime Raoust
 * @package Manialib
 */

/**
 * Exception for uncaught exceptions
 */
class FrameworkUncaughtException extends FrameworkException
{
	function __construct(FrameworkException $uncaughtException)
	{
		parent::__construct('Uncaught '.get_class($uncaughtException));
	}
}

?>
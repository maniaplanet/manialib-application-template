<?php
/**
 * @author Maxime Raoust
 * @package Manialib
 */

/**
 * Helps converting any exception into a FrameworkException
 */
class FrameworkImportedException extends FrameworkException
{
	function __construct(Exception $e)
	{
		parent::__construct($e->getMessage(), $e->getCode());
		$this->line = $e->getLine();
		$this->file = $e->getFile();
		$this->trace = $e->getTrace();
		// FIXME Message is wrong since iLog() is called in the parent constructor
	}
}

?>
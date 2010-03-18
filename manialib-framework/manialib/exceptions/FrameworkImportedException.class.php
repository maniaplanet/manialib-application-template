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
		parent::__construct($e->getMessage(), $e->getCode(), null, false);
		$this->line = $e->getLine();
		$this->file = $e->getFile();
		$this->trace = $e->getTrace();
		$this->optionalMessageLabel = 'Imported';
		$this->optionalMessageContent = get_class($e);
		$this->iLog();
	}
}

?>
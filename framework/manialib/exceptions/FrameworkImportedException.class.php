<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * Exception importer
 * 
 * Helps converting any exception into a FrameworkException
 */
class FrameworkImportedException extends FrameworkException
{
	function __construct(Exception $e)
	{
		parent::__construct($e->getMessage(), $e->getCode(), null, false);
		$this->line = $e->getLine();
		$this->file = $e->getFile();
		$this->addOptionalInfo('Imorted from', get_class($e));
		$this->iLog();
	}
}

?>
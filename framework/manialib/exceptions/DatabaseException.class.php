<?php
/**
 * @package Manialib
 * @author Maxime Raoust
 */

/**
 * Database exception
 */
class DatabaseException extends FrameworkException
{
	function __construct($query='')
	{
		parent::__construct(mysql_error(), mysql_errno(), null, false);
		$this->addOptionalInfo('Query', $query);
		$this->iLog();
	}
}
?>
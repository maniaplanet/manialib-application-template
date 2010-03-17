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
	protected $query;
	function __construct($query='')
	{
		parent::__construct(mysql_error(), mysql_errno());
		$this->query = $query;
	}
}
?>
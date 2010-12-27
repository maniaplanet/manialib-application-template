<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Abstract service
 */
abstract class ManiaLib_Services_AbstractService
{
	/**
	 * @var ManiaLib_Database_Connection
	 */
	protected $db;
	
	function __construct()
	{
		$this->db = ManiaLib_Database_Connection::getInstance();
	}
}


?>
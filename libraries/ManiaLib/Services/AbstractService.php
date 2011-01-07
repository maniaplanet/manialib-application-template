<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\Services;

/**
 * Abstract service
 */
abstract class AbstractService
{
	/**
	 * @var \ManiaLib\Database\Connection
	 */
	protected $db;
	
	function __construct()
	{
		$this->db = \ManiaLib\Database\Connection::getInstance();
	}
}


?>
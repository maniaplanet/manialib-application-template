<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @see         http://code.google.com/p/manialib/
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\Database;

/**
 * @method \ManiaLib\Database\Config getInstance()
 */
class Config extends \ManiaLib\Utils\Singleton
{

	public $host = '127.0.0.1';
	public $user = 'root';
	public $password = '';
	public $database;
	public $charset = 'utf8';
	public $queryLog = false;
	public $slowQueryLog = false;
	public $slowQueryThreshold = 1500; // in ms

}

?>
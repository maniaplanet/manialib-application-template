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

namespace ManiaLib\Database;

/**
 * Database config
 */
class Config extends \ManiaLib\Utils\Singleton
{
	public $host = '127.0.0.1';
	public $user = 'root';
	public $password = '';
	public $database;
	public $charset = 'utf8';
	
	public $queryLog = false;
	public $queryLogFilename = 'queries.log';
	public $slowQueryLog = false;
	public $slowQueryLogFilename = 'slow-queries.log';
	public $slowQueryThreshold = 1000; // in ms
}

?>
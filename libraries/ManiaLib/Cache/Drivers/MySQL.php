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

namespace ManiaLib\Cache\Drivers;

/**
 * MySQL Cache Driver.
 * To replace MemCache or APC if you can't use any of them on your server.
 * You must configure your MySQL connection in app.ini and create the table with the following request

  CREATE TABLE `manialib_cache` (
  `name` VARCHAR(255) NOT NULL,
  `value` TEXT NOT NULL COLLATE 'utf8_general_ci',
  `ttl` TIMESTAMP NOT NULL,
  PRIMARY KEY (`name`),
  INDEX `ttl` (`ttl`)
  )

 * Expired objects are not deleted automatically so if your table is growing too large, you'll have to clean it manually
 */
class MySQL extends \ManiaLib\Utils\Singleton implements \ManiaLib\Cache\CacheInterface
{

	protected $db;
	protected $dbName;

	protected function __construct()
	{
		$this->db = \ManiaLib\Database\Connection::getInstance();
		$this->dbName = \ManiaLib\Database\Config::getInstance()->database;
	}

	/**
	 * @return \ManiaLib\Database\Connection 
	 */
	private function db()
	{
		$this->db->select($this->dbName);
		return $this->db;
	}

	function fetch($key)
	{
		$raw = $this->db()->execute(
			'SELECT value, ttl=0 OR ttl>=NOW() AS alive FROM manialib_cache WHERE name=%s',
			$this->db()->quote($key));

		if($raw->recordCount() != 1)
			return false;

		$var = $raw->fetchAssoc();
		return $var['alive'] ? unserialize($var['value']) : false;
	}

	function add($key, $value, $ttl=0)
	{
		$ttl = intval($ttl);
		$this->db()->execute(
			'INSERT manialib_cache VALUES (%s, %s, DATE_ADD(NOW(), INTERVAL %d SECOND)) ON DUPLICATE KEY UPDATE '.
			'value=IF(ttl=0 OR ttl>=NOW(), value, VALUES(value)), '.
			'ttl=IF(ttl=0 OR ttl>=NOW(), ttl, VALUES(ttl))', $this->db()->quote($key),
			$this->db()->quote(serialize($value)), $ttl == 0 ? 0 : $ttl);	}

	function replace($key, $value, $ttl=0)
	{
		$ttl = intval($ttl);
		$this->db()->execute(
			'UPDATE manialib_cache SET value=DATE_ADD(NOW(), INTERVAL %d SECOND), ttl=%s WHERE name=%s',
			$this->db()->quote(serialize($value)), $ttl == 0 ? 0 : $ttl,			$this->db()->quote($key));
	}

	function delete($key)
	{
		$this->db()->execute(
			'DELETE FROM manialib_cache WHERE name=%s', $this->db()->quote($key));
	}

	function inc($key)
	{
		if(($value = $this->fetch($key)) !== false && is_int($value))
			$this->db()->execute(
				'UPDATE manialib_cache SET value=%s WHERE name=%s',
				$this->db()->quote(serialize($value + 1)), $this->db()->quote($key));
	}

}

?>
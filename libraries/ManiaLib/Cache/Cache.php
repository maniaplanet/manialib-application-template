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

namespace ManiaLib\Cache;

/**
 * La classe qu'on a du mal à la trouver
 */
abstract class Cache
{
	const DRIVER_NO_CACHE = 1;
	const DRIVER_APC = 2;
	
	static private $instances = array();
	
	/**
	 * @return \ManiaLib\Cache\Cache
	 */
	public static function getInstance($driver = null)
	{
		if (!array_key_exists($driver, self::$instances) || !self::$instances[$driver])
		{
			if($driver === null)
			{
				if(function_exists('apc_add'))
				{
					$driver = self::DRIVER_APC;
				}
				else
				{
					$driver = self::DRIVER_NO_CACHE;
				}
			}
			switch($driver)
			{
				case self::DRIVER_APC:
					self::$instances[$driver] = new \ManiaLib\Cache\Drivers\APC();
					break;
					
				case self::DRIVER_NO_CACHE:
					self::$instances[$driver] = new \ManiaLib\Cache\Drivers\NoCache();
					break;
				
				default:
					throw new Exception('Unknown driver: '.$driver);
			}
		}
		return self::$instances[$driver];
	}
	
	/**
	 * Returns a unique key based on the file location to avoid cache conflicts
	 * when several applications are running on the same server
	 */
	static public function getUniqueAppCacheKeyPrefix()
	{
		return crc32(__FILE__);
	}
	
	abstract function exists($key);
	/**
	 * @deprecated
	 */
	abstract function get($key);
	abstract function fetch($key); 
	abstract function add($key, $value, $ttl=0);
	abstract function store($key, $value, $ttl=0);
	abstract function delete($key);
	abstract function clearCache();
	abstract function inc($key);
}

class Exception extends \Exception {}

?>
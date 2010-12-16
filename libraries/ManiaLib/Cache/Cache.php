<?php

/**
 * La classe qu'on a du mal à la trouver
 */
abstract class ManiaLib_Cache_Cache
{
	const DRIVER_NO_CACHE = 1;
	const DRIVER_APC = 2;
	
	static private $instance;
	
	/**
	 * @return ManiaLib_Cache_Cache
	 */
	public static function getInstance($driver = null)
	{
		if (!self::$instance)
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
					self::$instance = new ManiaLib_Cache_Drivers_APC();
					break;
					
				case self::DRIVER_NO_CACHE:
					self::$instance = new ManiaLib_Cache_Drivers_NoCache();
					break;
				
				default:
					throw new Exception('ManiaLib_Cache: Unknown driver: '.$driver);
			}
		}
		return self::$instance;
	}
	
	abstract function exists($key);
	abstract function get($key);
	abstract function add($key, $value, $ttl=0);
	abstract function delete($key);
	abstract function clearCache();
}

?>
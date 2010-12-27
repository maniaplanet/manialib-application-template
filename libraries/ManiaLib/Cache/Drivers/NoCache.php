<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * NoCache driver
 * You should NOT use this driver in production, use APC instead
 */
class ManiaLib_Cache_Drivers_NoCache extends ManiaLib_Cache_Cache
{
	function exists($key)
	{
		return false;
	}
	
	function get($key)
	{
		throw new Exception('Value does not exists in cache (NoCache driver)');
	}
	
	function add($key, $value, $ttl=0) {}
	
	function delete($key) {}
	
	function clearCache() {}
}


?>
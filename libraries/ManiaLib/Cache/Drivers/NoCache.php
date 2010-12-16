<?php

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
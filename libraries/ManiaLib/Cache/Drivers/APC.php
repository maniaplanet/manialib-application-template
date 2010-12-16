<?php

class ManiaLib_Cache_Drivers_APC extends ManiaLib_Cache_Cache
{
	function exists($key)
	{
		return apc_exists($key);
	}
	
	function get($key)
	{
		return apc_fetch($key);
	}
	
	function add($key, $value, $ttl=0)
	{
		if(!apc_add($key, $value, $ttl))
		{
			throw new Exception('apc_add('.$key.') failed');
		}
	}
	
	function delete($key)
	{
		if(!apc_delete($key))
		{
			throw new Exception('apc_delete('.$key.') failed');
		}
	}
	
	function clearCache()
	{
		if(!apc_clear_cache())
		{
			throw new Exception('apc_clear_cache() failed');
		}
	}
}

?>
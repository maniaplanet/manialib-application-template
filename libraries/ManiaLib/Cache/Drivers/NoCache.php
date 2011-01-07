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

namespace ManiaLib\Cache\Drivers;

/**
 * NoCache driver
 * You should NOT use this driver in production, use APC instead
 */
class NoCache extends \ManiaLib\Cache\Cache
{
	function exists($key)
	{
		return false;
	}
	
	function get($key)
	{
		throw new \Exception('Value does not exists in cache (NoCache driver)');
	}
	
	function fetch($key)
	{
		throw new \Exception('Value does not exists in cache (NoCache driver)');
	}
	
	function add($key, $value, $ttl=0) {}
	
	function store($key, $value, $ttl=0) {}
	
	function delete($key) {}
	
	function clearCache() {}
	
	function inc($key) {}
}


?>
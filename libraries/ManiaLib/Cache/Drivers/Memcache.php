<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2782 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-03-04 18:58:33 +0100 (ven., 04 mars 2011) $:
 */

namespace ManiaLib\Cache\Drivers;

/**
 * Memcache driver based on the PECL\Memcache extension
 * @see http://www.php.net/manual/en/book.memcache.php
 */
class Memcache extends \ManiaLib\Utils\Singleton implements \ManiaLib\Cache\CacheInterface
{
	/**
	 * @var \Memcache
	 */
	protected $memcache;
	
	protected function __construct()
	{
		if(!class_exists('Memcache'))
		{
			throw new Exception('PECL\Memcache extension not found');
		}
		// TODO MANIALIB Memcached should we use the persistent Id ?
		$this->memcache = new \Memcache();
		
		$config = MemcacheConfig::getInstance();
		foreach($config->hosts as $host)
		{
			$this->memcache->addServer($host);
		}
	}
	
	function exists($key)
	{
		return !($this->fetch($key) === false);
	}
	
	function fetch($key)
	{
		$key = str_replace('\\', '/', $key);
		return $this->memcache->get($key);
	}
	
	function add($key, $value, $ttl=0) 
	{
		$key = str_replace('\\', '/', $key);
		if(!$this->memcache->add($key, $value, false, $ttl))
		{
			throw new Exception(sprintf('Memcache::set() with key "%s" failed', $key));
		}
	}
	
	function replace($key, $value, $ttl=0) 
	{
		$key = str_replace('\\', '/', $key);
		if(!$this->memcache->replace($key, $value, false, $ttl))
		{
			throw new Exception(sprintf('Memcache::replace() with key "%s" failed', $key));
		}
	} 
	
	function delete($key) 
	{
		$key = str_replace('\\', '/', $key);
		if(!$this->memcache->delete($key))
		{
			throw new Exception(sprintf('Memcache::delete() with key "%s" failed', $key));
		}
	}
	
	function inc($key) 
	{
		$key = str_replace('\\', '/', $key);
		if(!$this->memcache->increment($key))
		{
			throw new Exception(sprintf('Memcache::increment() with key "%s" failed', $key));
		}
	}
}

?>
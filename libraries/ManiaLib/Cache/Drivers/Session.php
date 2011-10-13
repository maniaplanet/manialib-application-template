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
 * Session-based cache. Usefull for development is you really need
 * a cache, but you should not use that in production.
 * 
 * NOTE THAT TTL DOES NOT WORK WITH SESSIONS!
 * 
 */
class Session extends \ManiaLib\Utils\Singleton implements \ManiaLib\Cache\CacheInterface
{
	/**
	 * @var \ManiaLib\Application\Session
	 */
	protected $session;
	
	protected function __construct()
	{
		$this->session = \ManiaLib\Application\Session::getInstance();
	}
		
	function fetch($key)
	{
		$value = $this->session->get($key);
		if($value)
		{
			return unserialize($value);
		}
		return false;
	}
	
	function add($key, $value, $ttl=0) 
	{
		return $this->session->set($key, serialize($value));
	}
	
	function replace($key, $value, $ttl=0) 
	{
		$this->session->set($key, serialize($value));
	} 
	
	function delete($key) 
	{
		$this->session->delete($key);
	}
	
	function inc($key) 
	{
		$value = $this->get($key);
		$this->session->set($key, serialize($value+1));
	}
}

?>
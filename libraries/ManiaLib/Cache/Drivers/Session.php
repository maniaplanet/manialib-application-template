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
 * Session-based cache. Usefull for development is you really need
 * a cache, but you should not use that in production.
 * 
 * NOTE THAT TTL DOES NOT WORK WITH SESSIONS!
 * 
 */
class Session extends \ManiaLib\Utils\Singleton implements \ManiaLib\Cache\CacheInterface
{
	/**
	 * @var \ManiaLib\Session\Session
	 */
	protected $session;
	
	protected function __construct()
	{
		$this->session = \ManiaLib\Session\Session::getInstance();
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
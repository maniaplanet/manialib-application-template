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

namespace ManiaLib\Statistics;

class Sampler
{
	protected static $instance;
	
	/**
	 * @var \ManiaLib\Cache\Cache
	 */
	protected $cache;
	
	static function getInstance()
	{
		if(!self::$instance)
		{
			self::$instance = new self;
		}
		return self::$instance;
	}
	
	protected function __construct()
	{
		$this->cache = \ManiaLib\Cache\Cache::getInstance(); 
	}
	
	function logRequest()
	{
		try 
		{
			$key = \ManiaLib\Cache\Cache::getUniqueAppCacheKeyPrefix().'_Requests';
			if(!$this->cache->exists($key))
			{
				$this->cache->add($key, 1);
			}
			else 
			{
				$this->cache->inc($key);
			}
		}
		catch(\Exception $e) {}
	}
}


?>
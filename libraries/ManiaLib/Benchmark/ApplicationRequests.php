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
 
namespace ManiaLib\Benchmark;

/**
 * Tool for benchmarking application performance.
 * 
 * It stores the data in the cache: number of requests (inc counter) and a
 * stack of execution times so we can make Munin graphs out of it.
 * 
 * You should not need to use it unless you are running very high demand apps.
 */
abstract class ApplicationRequests
{
	public static function touch($mtimeStart = 0)
	{
		try 
		{
			$config = Config::getInstance();
			if(!$config->enabled || !defined('APP_ID'))
			{
				return;
			}
			
			$cache = \ManiaLib\Cache\Cache::factory('memcache');
			$prefix = \ManiaLib\Cache\Cache::getPrefix();
			$registeredAppsKeys = 'maniastudio_registered_applications';
			$requestKey = $prefix.'requests_count';
			$benchmarkKey = $prefix.'requests_benchmark';
			
			// First we register the application in a stack in the cache
			// so that we can easilly fetch data of multiple apps from teh cache
			$registeredApps = $cache->fetch($registeredAppsKeys);
			if(!$registeredApps || !is_array($registeredApps))
			{
				$registeredApps = array(APP_ID);
				$cache->add($registeredAppsKeys, $registeredApps);
			}
			elseif(!in_array(APP_ID, $registeredApps))
			{
				$registeredApps[] = APP_ID;
				$cache->replace($registeredAppsKeys, $registeredApps);
			}
			
			// Then we increment the counter for that app
			$count = $cache->fetch($requestKey);
			if(!$count)
			{
				$count = 0;
				$cache->add($requestKey, $count);
			}
			$cache->inc($requestKey);
			
			// And we check if we need to store the execution time
			if($count < $config->maxElements || rand(0, $config->samplingRate) == 0)
			{
				if($mtimeStart)
				{
					$benchmark = $cache->fetch($benchmarkKey);
					if(!$benchmark || !is_array($benchmark))
					{
						$benchmark = array();
						$cache->add($benchmarkKey, $benchmark);
					}
					while($config->maxElements && count($benchmark) > $config->maxElements)
					{
						array_pop($benchmark);
					}
					$diff = microtime(true) - $mtimeStart;
					array_unshift($benchmark, $diff);
					$cache->replace($benchmarkKey, $benchmark);
				}
			}
		}
		catch(\Exception $e) {}
	}
}

?>
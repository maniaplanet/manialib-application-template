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
 * You should not need to use it unless you are running very high demande apps.
 */
abstract class ApplicationRequests
{
	const SAMPLING_RATE = 100;
	const BENCHMARK_MAX_ELEMENTS = 50;

	/**
	 * Call this method at the end of your page execution
	 */
	public static function touch($mtimeStart = 0)
	{
		try 
		{
			if(!is_object(\ManiaLib\Config\Loader::$config->benchmark))
			{
				return;
			}
			
			$config = \ManiaLib\Config\Loader::$config->benchmark;
			
			if(!$config->enabled)
			{
				return;
			}
			
			$cache = \ManiaLib\Cache\Cache::getInstance();
			$prefix = \ManiaLib\Cache\Cache::getUniqueAppCacheKeyPrefix();
			$requestKey = $prefix.'_requests_count';
			$benchmarkKey = $prefix.'_requests_benchmark';
			
			if(!$cache->exists($requestKey))
			{
				$count = 0;
				$cache->store($requestKey, $count);
			}
			else
			{
				$count = $cache->fetch($requestKey);
			}
			$cache->inc($requestKey);
			
			if($count < $config->maxElements || $count % $config->samplingRate == 1)
			{
				if($mtimeStart)
				{
					$diff = microtime(true) - $mtimeStart;
					if(!$cache->exists($benchmarkKey))
					{
						$benchmark = array();
					}
					else
					{
						$benchmark = $cache->fetch($benchmarkKey);
						if(!is_array($benchmark))
						{
							$benchmark = array();
						}
					}
					if(count($benchmark) > $config->maxElements)
					{
						array_pop($benchmark);
					}
					array_unshift($benchmark, $diff);
					$cache->store($benchmarkKey, $benchmark);
				}
			}
		}
		catch(\Exception $e) {}
	}
}

?>
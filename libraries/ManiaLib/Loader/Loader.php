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

namespace ManiaLib\Loader;

/**
 * Smart loader
 * Used to load classes and put them in the cache (eg. configs, langs etc.)
 */
abstract class Loader extends \ManiaLib\Utils\Singleton
{
	static $enableDump = false;
	public $message;
	protected $debugPrefix;
	protected $cacheEnabled = true;
	protected $cacheDriver;
	protected $cacheKey;
	/**
	 * @var \ManiaLib\Cache\Cache
	 */
	protected $cache;
	protected $data;
	
	/**
	 * Singleton with self::getInstance() must be declared in childs 
	 */
	protected function __construct()
	{
		$this->cacheEnabled = true;
		$this->cacheKey = \ManiaLib\Cache\Cache::getUniqueAppCacheKeyPrefix().'_'.get_class($this);
	}
	
	protected final function initCache()
	{
		if($this->cacheEnabled && !$this->cache)
		{
			if($this->cacheDriver)
			{
				$this->cache = \ManiaLib\Cache\Cache::getInstance($this->cacheDriver);
			}
			else
			{
				$this->cache = \ManiaLib\Cache\Cache::getInstance();
			}
		}		
	}
	
	function enableCache()
	{
		$this->cacheEnabled = true;
	}
	
	function disableCache()
	{
		$this->cacheEnabled = false;
	}
	
	function setCacheDriver($driver)
	{
		$this->cacheDriver = $driver;
	}
	
	final function smartLoad()
	{
		try 
		{
			ob_start();
			if($this->cacheEnabled)
			{
				$this->initCache();
				if($this->cache->exists($this->cacheKey))
				{
					$this->data = $this->cache->fetch($this->cacheKey);
					$this->postCacheLoad();
					$this->postLoad();
				}
				else
				{
					$this->runtimeLoad();
					$this->postLoad();
					$this->cache->add($this->cacheKey, $this->data);
					$this->debug('Data cached at "'.$this->cacheKey.'"');
				}
			}
			else
			{
				$this->runtimeLoad();
				$this->postLoad();
			}
			$this->message = ob_get_contents();
			ob_end_clean();
			if($this->message && $this->cache && $this->cache->enableLogging())
			{
				\ManiaLib\Log\Logger::loader("\n".$this->message);
			}
		}
		catch(\Exception $exception)
		{
			ob_end_clean();
			throw $exception;
		}
	}
	
	final function testLoad()
	{
		try 
		{
			$this->disableCache();
			$this->runtimeLoad();
			echo $this->message;
		} 
		catch (\Exception $e) 
		{
			echo $this->message;
			echo 'ERROR: '.$e->getMessage();
		}
	}
	
	final protected function runtimeLoad()
	{
		$mtime = microtime(true);
		$this->preLoad();
		$this->data = $this->load();
		if(static::$enableDump)
		{
			$this->debug("Data dump:\n\n".print_r($this->data, true));
		}
		$mtime = microtime(true) - $mtime;
		$this->debug('Loaded in '.number_format($mtime*1000, 2).' milliseconds');
	}
	
	/**
	 * Stuff to do before loading
	 * Eg. verifiy the params
	 */
	protected function preLoad() {}
	
	/**
	 * Stuff to do after loading, AT EVERY REQUEST !
	 * Eg. put $this->data in a static prop
	 */
	protected function postLoad() {}
	
	/**
	 * Loads the stuff and returns it
	 */
	abstract protected function load();
	
	/**
	 * Stuff to be done when the data has been loaded from cache 
	 */
	protected function postCacheLoad() {}
	
	protected function debug($message)
	{
		echo $this->debugPrefix.' '.$message."\n";
	}
	
}

?>
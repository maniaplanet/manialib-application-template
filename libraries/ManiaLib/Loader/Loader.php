<?php

abstract class ManiaLib_Loader_Loader
{
	protected $debugPrefix;
	protected $cacheEnabled = true;
	protected $cacheDriver;
	protected $cacheKey;
	/**
	 * @var ManiaLib_Cache_Cache
	 */
	protected $cache;
	protected $data;
	
	/**
	 * Singleton with self::getInstance() must be declared in childs 
	 */
	protected function __construct()
	{
		$this->cacheEnabled = true;
		// FIXME Several ManiaLib application on one server == Cache collisions
		$this->cacheKey = get_class($this);
	}
	
	protected final function initCache()
	{
		if($this->cacheEnabled && !$this->cache)
		{
			if($this->cacheDriver)
			{
				$this->cache = ManiaLib_Cache_Cache::getInstance($this->cacheDriver);
			}
			else
			{
				$this->cache = ManiaLib_Cache_Cache::getInstance();
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
					$this->data = $this->cache->get($this->cacheKey);
					$this->postLoad();
				}
				else
				{
					$this->runtimeLoad();
					$this->postLoad();
					$this->cache->add($this->cacheKey, $this->data);
					$this->debug('Data successfully cached with key "'.$this->cacheKey.'"');
				}
			}
			else
			{
				$this->runtimeLoad();
				$this->postLoad();
			}
			$message = ob_get_contents();
			ob_end_clean();
			if($message)
			{
				ManiaLib_Log_Logger::loader("\n".$message);
			}
		}
		catch(Exception $exception)
		{
			ob_end_clean();
			throw $exception;
		}
	}

	final protected function runtimeLoad()
	{
		$mtime = microtime(true);
		$this->debug('Starting runtime load');
		$this->preLoad();
		$this->debug('Pre-load completed');
		$this->data = $this->load();
		$this->debug('Load completed');
		$this->debug("Data dump:\n\n".print_r($this->data, true));
		$mtime = microtime(true) - $mtime;
		$this->debug('Runtime load completed in '.number_format($mtime*1000, 2).' milliseconds');
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
	
	protected function debug($message)
	{
		echo $this->debugPrefix.' '.$message."\n";
	}
	
}

?>
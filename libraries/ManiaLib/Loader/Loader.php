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
	static $enableCache = true;
	
	public $message;
	protected $debugPrefix;
	protected $cacheKey;
	/**
	 * @var \ManiaLib\Cache\CacheInterface
	 */
	protected $cache;
	public $data;
	
	/**
	 * Singleton with self::getInstance() must be declared in childs 
	 */
	protected function __construct()
	{
		$this->cacheKey = \ManiaLib\Cache\Cache::getPrefix().get_class($this);
		$this->cache = \ManiaLib\Cache\Cache::factory(static::$enableCache?'apc':'nocache');
	}
	
	final function smartLoad()
	{
		try 
		{
			ob_start();
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
			$this->message = ob_get_contents();
			ob_end_clean();
			
			// Only log if APC is loaded (fallback NoCache driver won't log anything)
			if($this->message && $this->cache instanceof \ManiaLib\Cache\Drivers\APC)
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
			$this->runtimeLoad();
			$this->postLoad();
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
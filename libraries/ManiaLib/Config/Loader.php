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

namespace ManiaLib\Config;

/**
 * Config loader
 */
class Loader extends \ManiaLib\Loader\Loader
{
	/**
	 * @var \ManiaLib\Config\Config
	 */
	static $config;
	
	protected static $instance;
	
	protected $debugPrefix = '[CONFIG LOADER]';
	protected $configFilename;
	protected $configClassname = '\ManiaLib\Config\Config';
	
	/**
	 * @return \ManiaLib\Config\Loader
	 */
	static function getInstance()
	{
		if(!self::$instance)
		{
			self::$instance = new self();
		}
		return self::$instance;
	}

	function setConfigFilename($configFilename)
	{
		$this->configFilename = $configFilename;
	}
	
	function setConfigClassname($configClassname)
	{
		
		$this->configClassname = $configClassname;
	}
	
	protected function preLoad()
	{
		if(!file_exists($this->configFilename))
		{
			throw new \Exception($this->configFilename.' does not exist');
		}
		if(!is_subclass_of($this->configClassname, '\ManiaLib\Config\Configurable'))
		{
			throw new \InvalidArgumentException(
				$this->configClassname.' must be a subclass of \ManiaLib\Config\Configurable');
		}
	}
	
	protected function postLoad()
	{
		self::$config = $this->data;
	}
	
	/**
	 * @return \ManiaLib\Config\Config
	 */
	protected function load()
	{
		$values = $this->loadINI($this->configFilename);
		$this->debug($this->configFilename.' parsed');
		list($values, $overrides) = $this->scanOverrides($values);
		$values = $this->processOverrides($values, $overrides);
		$values = $this->associateArray($values);
		$config = $this->arrayToConfig($values);
		$config->doValidate();
		if(defined('APP_ID'))
		{
			// Register the object in the cache if the benchmarking is enabled
			// This is done so that a Munin plugin can know what applications
			// should be graphed.
			if(is_object($config->benchmark) && $config->benchmark->enabled)
			{
				$key = 'maniastudio_registered_applications';
				if($this->cache->exists($key))
				{
					$registeredApps = $this->cache->fetch($key);
					if(!is_array($registeredApps))
					{
						$registeredApps = array();
					}
				}
				else
				{
					$registeredApps = array();
				}
				if(!in_array(APP_ID, $registeredApps))
				{
					$registeredApps[] = APP_ID;
				}
				$this->cache->store($key, $registeredApps);
			}
		}
		return $config;
	}
	
	/**
	 * @return array
	 */
	protected function loadINI($filename)
	{
		try 
		{
			return parse_ini_file($filename, true);
		}
		catch(\Exception $e)
		{
			throw new \Exception('Could not parse INI file: '.$e->getMessage());
		}
	}
	
	/**
	 * Creates two arrays (values and ovverides) from one array
	 * @return array(array values, array overrides)
	 */
	protected function scanOverrides(array $array)
	{
		$values = array();
		$overrides = array();
		
		foreach($array as $key => $value)
		{
			if(strstr($key, ':'))
			{
				$overrides[$key] = $value;
			}
			else
			{
				$values[$key] = $value;
			}
		}
		return array($values, $overrides);
	}
	
	/**
	 * Checks if the values from overrides actually match an ovveride rule, anb
	 * override teh values array if it's the case
	 * @return array
	 */
	protected function processOverrides(array $values, array $overrides)
	{
		if($overrides)
		{
			if(isset($_SERVER) && array_key_exists('HTTP_HOST', $_SERVER))
			{
				foreach($overrides as $key => $override)
				{
					$matches = null;
					if(preg_match('/^hostname: (.+)$/i', $key, $matches))
					{
						if($matches[1] == $_SERVER['HTTP_HOST'])
						{
							$this->debug('Found hostname override: '.$matches[1]);
							$values = $this->overrideArray($values, $override);
							break;
						}
					}
				}
			}
		}
		return $values;
	}
	
	/**
	 * Overrides the values of the source array with values from teh overrride array
	 * It does not work with associate arrays
	 * @return array
	 */
	protected function overrideArray(array $source, array $override)
	{
		foreach($override as $key => $value)
		{
			$source[$key] = $value;
		}
		return $source;
	}
	
	/**
	 * Converts a normal array with keys that contains "." to an associative array
	 * @return array
	 */
	protected function associateArray(array $array)
	{
		$result = array();
		foreach ($array as $key => $value)
		{
			$sections = explode('.', $key);
			$pointer =& $result;
			foreach($sections as $section)
			{
				if(!array_key_exists($section, $pointer))
				{
					$pointer[$section] = array();
				}
				$pointer =& $pointer[$section];
			}
			$pointer = $value;
		}
		return $result;
	}
	
	/**
	 * @return \ManiaLib\Config\Config
	 */
	protected function arrayToConfig($values)
	{
		$config = new $this->configClassname;
		$this->importValues($values, $config);
		return $config;
	}
	
	/**
	 * Puts the values from the array into the config class
	 */
	protected function importValues(array $values, \ManiaLib\Config\Configurable $config)
	{
		foreach($values as $key => $value)
		{
			if(property_exists($config, $key))
			{
				if($config->$key instanceof \ManiaLib\Config\Configurable)
				{
					$this->importValues($value, $config->$key);
				}
				else
				{
					if($config->$key)
					{
						$this->debug('Overriding '.get_class($config).'::$'.$key);
					}
					$config->$key = $value;
				}
			}
			else
			{
				$this->debug('Warning: '.get_class($config).'::$'.$key.' does not exists');
			}
		}
	}
}

?>
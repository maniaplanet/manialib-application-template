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
	static $aliases = array(
		'application' => 'ManiaLib\\Application\\Config',
		'authentication' => 'ManiaLib\\Authentication\\Config',
		'benchmark' => 'ManiaLib\\Benchmark\\Config',
		'cache' => 'ManiaLib\\Cache\\Config',
		'config' => 'ManiaLib\\Config\\Config',
		'database' => 'ManiaLib\\Database\\Config',
		'i18n' => 'ManiaLib\\I18n\\Config',
		'log' => 'ManiaLib\\Log\\Config',
		'maniahome' => 'ManiaLib\\ManiaHome\\Config',
		'restclient' => 'ManiaLib\\Rest\\Config',
		'session' => 'ManiaLib\Session\Config',
		'smarty' => 'ManiaLib\\Application\\Rendering\\SmartyConfig',
		'tracking' => 'ManiaLib\\Application\\Tracking\\Config',
	);
	
	protected $debugPrefix = '[CONFIG LOADER]';
	protected $configFilename;

	function setConfigFilename($configFilename)
	{
		$this->configFilename = $configFilename;
	}
	
	protected function preLoad()
	{
		if(!$this->configFilename)
		{
			$this->configFilename = APP_PATH.'config/app.ini';
		}
	}
	
 	protected function load()
	{
		$values = $this->loadINI($this->configFilename);
		list($values, $overrides) = $this->scanOverrides($values);
		$values = $this->processOverrides($values, $overrides);
		$values = $this->loadAliases($values);
		$values = $this->replaceAliases($values);
		$instances = $this->arrayToSingletons($values);
		$this->debug(sprintf('Loaded %d class instances', count($instances)));
		return $instances;
	}
	
	/**
	 * @return array
	 */
	protected function loadINI($filename)
	{
		if(!file_exists($filename))
		{
			$this->debug('No config file found');
			return array();
		}
		try 
		{
			$this->debug('Found config file '.$filename);
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
	 * @return array
	 */
	protected function loadAliases(array $values)
	{
		foreach ($values as $key => $value)
		{
			if(preg_match('/^\s*alias\s+(\S+)$/i', $key, $matches))
			{
				if(isset($matches[1]))
				{
					self::$aliases[$matches[1]] = $value;
					unset($values[$key]);
					$this->debug(sprintf('Found alias "%s"', $matches[1]));
				}
			}
		}
		return $values;
	}
	
	/**
	 * @return array
	 */
	protected function replaceAliases(array $values)
	{
		$newValues = array();
		foreach ($values as $key => $value)
		{
			$callback = explode('.', $key, 2);
			if(count($callback) == 2)
			{
				$className = reset($callback);
				$propertyName = end($callback);
				if(isset(self::$aliases[$className]))
				{
					$className = self::$aliases[$className];
				}
				$newValues[$className.'.'.$propertyName] = $value;
			}
			else
			{
				$newValues[$key] = $value;
			}
		}
		return $newValues;
	}
	
	/**
	 * @return array[Singleton]
	 */
	protected function arrayToSingletons($values)
	{
		$instances = array();
		foreach($values as $key => $value)
		{
			$callback = explode('.', $key, 2);
			if(count($callback) != 2)
			{
				$this->debug('Could not parse key='.$key);
				continue;
			}
			$className = reset($callback);
			$propertyName = end($callback);
			if(!class_exists($className))
			{
				$this->debug(sprintf('Class %s does not exists', $className));
				continue;
			}
			if(!is_subclass_of($className, '\\ManiaLib\\Utils\\Singleton'))
			{
				$this->debug(sprintf('Class %s must be an instance of \ManiaLib\Utils\Singleton', $className));
				continue;
			}
			if(!property_exists($className, $propertyName))
			{
				$this->debug(sprintf('%s::%s does not exists or is not public', $className, $propertyName));
				continue;
			}
			$instance = call_user_func(array($className, 'getInstance'));
			
			$instance->$propertyName = $value;
			$instances[$className] = $instance;
		}
		return $instances;
	}
	
	protected function postCacheLoad()
	{
		foreach ($this->data as $instance)
		{
			\ManiaLib\Utils\Singleton::forceInstance($instance);
		}
	}
}

?>
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

use ManiaLib\Cache\Cache;

abstract class NewLoader
{

	protected static $configFilename;
	protected static $hostname;
	protected static $enableCache = true;
	protected static $aliases = array(
		'application' => 'ManiaLib\\Application\\Config',
		'config' => 'ManiaLib\\Config\\Config',
		'database' => 'ManiaLib\\Database\\Config',
		'log' => 'ManiaLib\\Log\\Config',
		'tracking' => 'ManiaLib\\Application\\Tracking\\Config',
		'webservices' => 'ManiaLib\\WebServices\\Config',
	);

	static function setConfigFilename($filename)
	{
		self::$configFilename = $filename;
	}

	static function getConfigFilename()
	{
		if(!self::$configFilename)
		{
			self::$configFilename = APP_PATH.'config/app.ini';
		}
		return self::$configFilename;
	}

	static function setHostname($hostname)
	{
		self::$hostname = $hostname;
	}

	static function getHostname()
	{
		if(!self::$hostname)
		{
			self::$hostname = \ManiaLib\Utils\Arrays::get($_SERVER, 'HTTP_HOST');
		}
		return self::$hostname;
	}

	static function disableCache()
	{
		self::$enableCache = false;
	}

	static function load()
	{
		$key = Cache::getPrefix().get_called_class();
		$cache = Cache::factory(self::$enableCache ? \ManiaLib\Cache\APC : \ManiaLib\Cache\NONE);

		$values = $cache->fetch($key);
		if($values === false)
		{
			$values = parse_ini_file(self::getConfigFilename(), true);
			list($values, $overrides) = self::scanOverrides($values);
			$values = self::processOverrides($values, $overrides);
			$values = self::loadAliases($values);
			$values = self::replaceAliases($values);
			$cache->add($key, $values);
		}
		self::arrayToSingletons($values);
	}

	protected static function loadAliases(array $values)
	{
		foreach($values as $key => $value)
		{
			if(preg_match('/^\s*alias\s+(\S+)$/i', $key, $matches))
			{
				if(isset($matches[1]))
				{
					self::$aliases[$matches[1]] = $value;
					unset($values[$key]);
				}
			}
		}
		return $values;
	}

	protected static function replaceAliases(array $values)
	{
		$newValues = array();
		foreach($values as $key => $value)
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

	protected static function scanOverrides(array $array)
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

	protected static function processOverrides(array $values, array $overrides)
	{
		foreach($overrides as $key => $override)
		{
			$matches = null;
			if(preg_match('/^hostname: (.+)$/i', $key, $matches))
			{
				if($matches[1] == self::getHostname())
				{
					$values = self::overrideArray($values, $override);
					break;
				}
			}
		}
		return $values;
	}

	protected static function overrideArray(array $source, array $override)
	{
		foreach($override as $key => $value)
		{
			$source[$key] = $value;
		}
		return $source;
	}

	protected static function arrayToSingletons($values)
	{
		$instances = array();
		foreach($values as $key => $value)
		{
			$callback = explode('.', $key, 2);
			if(count($callback) != 2)
			{
				continue;
			}
			$className = reset($callback);
			$propertyName = end($callback);
			if(class_exists($className))
			{
				if(is_subclass_of($className, '\\ManiaLib\\Utils\\Singleton'))
				{
					if(property_exists($className, $propertyName))
					{
						$instance = call_user_func(array($className, 'getInstance'));
						$instance->$propertyName = $value;
					}
				}
			}
		}
	}

}

?>
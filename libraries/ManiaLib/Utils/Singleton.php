<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2315 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-02-11 20:35:17 +0100 (ven., 11 févr. 2011) $:
 */

namespace ManiaLib\Utils;

abstract class Singleton
{
	protected static $instances = array();
		
	static function getInstance()
	{
		$class = get_called_class();
		if(!isset(self::$instances[$class]))
		{
			self::$instances[$class] = new $class();
		}
		return self::$instances[$class];
	}
	
	/**
	 * Force a singleton object to be instanciated with the given instance
	 * Use with care!
	 */
	static function forceInstance(Singleton $object)
	{
		$class = get_class($object);
		if(!isset(self::$instances[$class]))
		{
			self::$instances[$class] = $object;
		}
		else
		{
			throw new \Exception(sprintf('Object of class %s was previously instanciated', $class));
		}
	}
	
	protected function __construct() {}
	
	final protected function __clone() {} 
}


?>
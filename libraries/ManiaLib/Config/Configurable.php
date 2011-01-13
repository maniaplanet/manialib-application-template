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
 * Config base class
 */
abstract class Configurable
{
	/**
	 * This is called once by the config loader to check the values are set as they should
	 * @see \ManiaLib\Config\Configurable::checkExists()
	 * @see \ManiaLib\Config\Configurable::setDefault()
	 */
	protected function validate() {}
	
	function __construct()
	{
		$reflect = new \ReflectionClass($this);
		$props = $reflect->getProperties();
		foreach($props as $prop)
		{
			if(!$prop->isStatic() && $prop->isPublic())
			{
				$comment = $prop->getDocComment();
				$matches = null;
				preg_match('/@var\s+(\S+)/', $comment, $matches);
				if(isset($matches[1]))
				{
					$class = $matches[1];
					if(class_exists($class))
					{
						if(is_subclass_of($class, '\ManiaLib\Config\Configurable'));
						{
							$key = $prop->getName();
							$this->$key = new $class;
						}
					}
				}
			}
		}
	}
	
	/**
	 * @deprecated Use "var" tag instead
	 */
	final protected function loadNestedConfig(array $classes)
	{
		foreach($classes as $property => $className)
		{
			if(property_exists($this, $property))
			{
				if(class_exists($className))
				{
					if(is_subclass_of($className, '\ManiaLib\Config\Configurable'))
					{
						$this->$property = new $className;
					}
				}
			}
		}
	}

	
	/**
	 * Check if a property is not null/empty, usefull for validation
	 * @throws Exception
	 */
	final protected function checkExists($property)
	{
		if(!$this->$property)
		{
			throw new Exception(get_class($this).'::'.$property.' must be defined');
		}
	}
	
	/**
	 * Define a property's default value if it is null/empty, usefull for validation
	 */
	final protected function setDefault($property, $value)
	{
		if(!$this->$property)
		{
			$this->$property = $value;
		}
	}
	
		/**
	 * Actually validates the config, and then all the nested configs
	 */
	final public function doValidate()
	{
		$this->validate();
		foreach($this as $key => $value)
		{
			if($value instanceof \ManiaLib\Config\Configurable)
			{
				$value->doValidate();
			}
		}
	}
}

?>
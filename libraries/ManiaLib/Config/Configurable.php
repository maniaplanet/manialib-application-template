<?php

abstract class ManiaLib_Config_Configurable
{
	/**
	 * This is called once by the config loader to check the values are set as they should
	 * @see ManiaLib_Config_Configurable::checkExists()
	 * @see ManiaLib_Config_Configurable::setDefault()
	 */
	protected function validate() {}
	
	function __construct() {}
	
//	final function __construct()
//	{
//		$reflect = new ReflectionClass($this);
//		$props = $reflect->getProperties();
//		foreach($props as $prop)
//		{
//			if(!$prop->isStatic() && $prop->isPublic())
//			{
//				$comment = $prop->getDocComment();
//				$matches = null;
//				preg_match('/@var ([[:alpha:][:alnum:]-_]+)/', $comment, $matches);
//				if(isset($matches[1]))
//				{
//					$class = $matches[1];
//					if(class_exists($class))
//					{
//						if(is_subclass_of($class, 'ManiaLib_Config_Configurable'));
//						{
//							$key = $prop->getName();
//							$this->$key = new $class;
//						}
//					}
//				}
//			}
//		}
//	}
	
	// TODO Deprecate ManiaLib_Config_Configurable::loadNestedConfig() and use @var tag when bug in HPHP is fixed
	
	/**
	 * This is how we load nested config classes.
	 * It would be way better to use the commented code above that automatically
	 * load nested classes from the "@var" tag.
	 * Unfortunately, HPHP doesn't support ReflectionProperty::getDocComments()
	 * for now...
	 */
	final protected function loadNestedConfig(array $classes)
	{
		foreach($classes as $property => $className)
		{
			if(property_exists($this, $property))
			{
				if(class_exists($className))
				{
					if(is_subclass_of($className, 'ManiaLib_Config_Configurable'))
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
			throw new ManiaLib_Config_Exception(get_class($this).'::'.$property.' must be defined');
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
			if($value instanceof ManiaLib_Config_Configurable)
			{
				$value->doValidate();
			}
		}
	}
}

?>
<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * ManiaLib_Application_Route class
 */
abstract class ManiaLib_Application_Route
{
	/**
	 * Use current
	 */
	const CUR = -1;
	/**
	 * Use default
	 */
	const DEF = -2;
	/**
	 * Don't use anything
	 */
	const NONE = -3;
	
	protected static $separator;
	
	static function separatorToUpperCamelCase($string)
	{
		return implode('', array_map('ucfirst', explode(self::getSeparator(), $string)));
	}
	
	static function separatorToCamelCase($string)
	{
		$string = implode('', array_map('ucfirst', explode(self::getSeparator(), $string)));
		$string[0] = strtolower($string[0]);
		return $string;
	}

	static function camelCaseToSeparator($string)
	{
		return strtolower(preg_replace('/([^A-Z])([A-Z])/', '$1'.self::getSeparator().'$2', $string)); 
	}
	
	protected static function getSeparator()
	{
		if(self::$separator === null)
		{
			self::$separator = ManiaLib_Config_Loader::$config->application->URLSeparator;
		}
		return self::$separator;
	}
}

?>
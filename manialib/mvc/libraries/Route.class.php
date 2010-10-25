<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib_MVC
 */

/**
 * Route class
 * 
 * @package ManiaLib_MVC
 */
abstract class Route
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
	
	static function separatorToUpperCamelCase($string)
	{
		return implode('', array_map('ucfirst', explode(APP_MVC_URL_SEPARATOR, $string)));
	}
	
	static function separatorToCamelCase($string)
	{
		return lcfirst(implode('', array_map('ucfirst', explode(APP_MVC_URL_SEPARATOR, $string))));
	}
	
	static function camelCaseToSeparator($string)
	{
		return strtolower(preg_replace('/([^A-Z])([A-Z])/', '$1'.APP_MVC_URL_SEPARATOR.'$2', $string)); 
	}
}

?>
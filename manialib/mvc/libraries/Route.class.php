<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 * @subpackage MVC
 */

/**
 * Route class
 * 
 * @package ManiaLib
 * @subpackage MVC
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
	
	/**
	 * @ignore
	 */
	static function separatorToUpperCamelCase($string)
	{
		return implode('', array_map('ucfirst', explode(APP_MVC_URL_SEPARATOR, $string)));
	}
	
	/**
	 * @ignore
	 */
	static function separatorToCamelCase($string)
	{
		$string = implode('', array_map('ucfirst', explode(APP_MVC_URL_SEPARATOR, $string)));
		$string[0] = strtolower($string[0]);
		return $string;
	}
	
	/**
	 * @ignore
	 */
	static function camelCaseToSeparator($string)
	{
		return strtolower(preg_replace('/([^A-Z])([A-Z])/', '$1'.APP_MVC_URL_SEPARATOR.'$2', $string)); 
	}
}

?>
<?php 
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Array stuff
 */
abstract class ManiaLib_Utils_Array
{
	static function get($array, $key, $default = null)
	{
		return array_key_exists($key, $array) ? $array[$key] : $default;
	}
}

?>
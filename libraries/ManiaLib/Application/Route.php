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

namespace ManiaLib\Application;

/**
 * Route class
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
			self::$separator = \ManiaLib\Config\Loader::$config->application->URLSeparator;
		}
		return self::$separator;
	}
}

?>
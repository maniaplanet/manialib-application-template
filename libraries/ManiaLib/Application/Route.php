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

	/**
	 * @param string A route like "/home/index/" or "/home/"
	 * @return array[string] An array of (controller, action) 
	 */
	static function getActionAndControllerFromRoute($route)
	{
		$defaultController = Config::getInstance()->defaultController;

		if(substr($route, 0, 1) == '/') $route = substr($route, 1);
		if(substr($route, -1, 1) == '/') $route = substr($route, 0, -1);
		$route = explode('/', $route, 2);

		$controller = \ManiaLib\Utils\Arrays::getNotNull($route, 0, $defaultController);
		$controller = Route::separatorToUpperCamelCase($controller);

		$action = \ManiaLib\Utils\Arrays::get($route, 1);
		$action = $action ? Route::separatorToCamelCase($action) : null;

		return array($controller, $action);
	}

	static function computeRoute($controller, $action)
	{
		$controller = static::camelCaseToSeparator($controller);
		$action = static::camelCaseToSeparator($action);
		$route = '/';
		if($controller)
		{
			$route .= $controller.'/';
			if($action)
			{
				$route .= $action.'/';
			}
		}
		return $route;
	}
	
	protected static function getSeparator()
	{
		if(self::$separator === null)
		{
			self::$separator = Config::getInstance()->URLSeparator;
		}
		return self::$separator;
	}
}

?>
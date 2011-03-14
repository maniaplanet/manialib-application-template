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

if(!defined('APP_PATH'))
{
	echo 'Fatal error: APP_PATH must be defined to your application root!';
	exit;			
}

define('APP_LIBRARIES_PATH', __DIR__);

function maniaLibAutoload($className)
{
	$className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
	$path = APP_LIBRARIES_PATH.DIRECTORY_SEPARATOR.$className.'.php';
	if(file_exists($path))
	{
		require_once $path;
	}
}

spl_autoload_register('maniaLibAutoload');

if(!function_exists('_'))
{
	function _($string)
	{
		return $string;
	}
}

?>
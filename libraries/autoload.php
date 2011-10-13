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
	die('Fatal error: APP_PATH must be defined to your application root!');
}

define('APP_LIBRARIES_PATH', __DIR__.DIRECTORY_SEPARATOR);
define('APP_RESSOURCES_PATH', APP_PATH.'ressources'.DIRECTORY_SEPARATOR);

function manialib_autoload($className)
{
	$className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
	$path = APP_LIBRARIES_PATH.$className.'.php';
	if(file_exists($path))
	{
		require_once $path;
	}
}

spl_autoload_register('manialib_autoload');
?>
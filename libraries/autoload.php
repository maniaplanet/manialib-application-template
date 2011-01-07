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

define('NAMESPACE_SEPARATOR', '\\');
define('MANIASTUDIO_LIBRARIES_PATH', dirname(__FILE__));

function __autoload($className)
{
	$className = str_replace(NAMESPACE_SEPARATOR, DIRECTORY_SEPARATOR, $className);
	$path = MANIASTUDIO_LIBRARIES_PATH.DIRECTORY_SEPARATOR.$className.'.php';
	if(file_exists($path))
	{
		require_once $path;
	}
}

function require_once_recursive($directory)
{
	if ($handle = opendir($directory))
	{
		while (false !== ($file = readdir($handle)))
		{
			if(substr($file, 0, 1)==".")
			{
				continue;
			}
			if(is_dir($directory.'/'.$file))
			{
				require_once_recursive($directory.'/'.$file);
			}
			else
			{
				require_once $directory.'/'.$file;
			}
		}
		closedir($handle);
	}
}

if(!function_exists('_'))
{
	function _($text)
	{
		return $text;
	}
}

?>
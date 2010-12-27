<?php

define('NAMESPACE_SEPARATOR', '_');
define('MANIASTUDIO_LIBRARIES_PATH', dirname(__FILE__));

function __autoload($className)
{
	$namespace = explode(NAMESPACE_SEPARATOR, $className);
	$className = array_pop($namespace);
	$namespace = implode(DIRECTORY_SEPARATOR, $namespace);
	$path = $namespace.DIRECTORY_SEPARATOR.$className.'.php';
	if(file_exists(MANIASTUDIO_LIBRARIES_PATH.DIRECTORY_SEPARATOR.$path))
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
<?php
/**
 * Misc functions
 * 
 * @author Maxime Raoust
 * @package Manialib
 */

/**
 * Class autoloader
 * @param string Class to load
 */
function __autoload($className)
{
	if(file_exists($path = APP_LIBRARIES_PATH.$className.'.class.php'))
	{
		require_once($path);
		return true;
	}
	if(file_exists($path = APP_FRAMEWORK_LIBRARIES_PATH.$className.'.class.php'))
	{
		require_once($path);
		return true;
	}
	if(file_exists($path = APP_FRAMEWORK_GUI_TOOLKIT_PATH.'cards/'.$className.'.class.php'))
	{
		require_once($path);
		return true;
	}
	if(file_exists($path = APP_FRAMEWORK_GUI_TOOLKIT_PATH.'layouts/'.$className.'.class.php'))
	{
		require_once($path);
		return true;
	}
	if(file_exists($path = APP_FRAMEWORK_EXCEPTIONS_PATH.$className.'.class.php'))
	{
		require_once($path);
		return true;
	}
	return false;
}

/**
 * Prints a line with a break at the end
 * @param string
 */
function println($string)
{
	echo $string."\n";
}

/**
 * Writes a message in the debug log
 * @param string The message
 * @param boolean Whether to add the date to the message
 * @param string The log filename
 */
function debuglog($msg, $addDate = true, $log = APP_DEBUG_LOG)
{
	if ($addDate)
	{
		$msg = date('d/m/y H:i:s') . " $msg\n";
	}
	file_put_contents($log, $msg, FILE_APPEND);
}

/**
 * Writes a pair name/value in the debug log, the value beeing print_r-ed
 * @param string The message
 * @param boolean Whether to add the date to the message
 * @param string The log filename
 */
 
function debuglogplusplus($name, $value)
{
	debuglog($name.'='.print_r($value, true));	
}

/**
 * Tries to get an element from an array. Returns the default value if not
 * found.
 * @param array Source array
 * @param string Array key
 * @param mixed Default value
 */
function array_get($array, $key, $default = null)
{
	if (isset ($array[$key]))
	{
		return $array[$key];
	}
	return $default;
}

/**
 * Allows to safely put any TM-formatted string into another TM-formatted string
 * without conflicts (conflict example: you put a nickname in the middle of the
 * sentance, the nickname has some bold characters and all the end of the
 * sentance becomes bold)
 * @param string Unprotected string
 * @param string Protected string
 */
function protectStyles($string)
{
	return "\$<$string\$>";
}

/**
 * Removes the protecting styles ($< and $>) from a string
 * @param string Protected string
 * @return string Unprotected string
 */
function unprotectStyles($string)
{
	return str_replace(array (
		'$<',
		'$>'
	), "", $string);
}

/**
 * Removes some TM styles (wide, bold and shadowed) to avoid wide words
 * @param string
 * @return string
 */
function stripWideFonts($string)
{
	return str_replace(array (
		'$w',
		'$o',
		'$s'
	), "", $string);
}

/**
 * Removes TM links
 * @param string
 * @return string
 */
function stripLinks($string)
{
	return preg_replace(
		'/\\$[hlp](.*?)(?:\\[.*?\\](.*?))*(?:\\$[hlp]|$)/ixu', '$1$2', 
		$string);
}

/**
 * Includes all the files from the specified directory
 * @param string Source directory
 */
function require_once_dir($path)
{
	if ($handle = opendir($path))
	{
		while (false !== ($file = readdir($handle)))
		{
			if (strcasecmp(substr($file, 0, 1), "."))
			{
				require_once ($path . $file);
			}
		}
		closedir($handle);
	}
}

/**
 * Safe division. Returns 0 if the denominator is 0
 * @param float Numerator
 * @param float Denominator
 * @return float Numerator/Denominator
 */
function safe_div($numerator, $denominator)
{
	if (!$denominator)
	{
		return 0;
	}
	return $numerator / $denominator;
}

/**
 * Formats a short english date from a timestamp
 * @param int
 * @return string
 */
function formatDate($timestamp)
{
	return date('l jS \of F Y', $timestamp);
}

/**
 * Formats an english date+time from a timestamp
 * @param int
 * @return string
 */
function formatLongDate($timestamp)
{
	return date('l jS \of F Y @ h:i A ', $timestamp).TIMEZONE_NAME;
}


if(LANG_ENGINE_MODE == LANG_ENGINE_MODE_DYNAMIC):
	
	/**
	 * i18n message. Examples: 
	 * echo __("hello_world"); 
	 * echo __("hello_login", $yetAnotherLogin);
	 * @param string
	 * @return string
	 */
	function __($textId)
	{
		$str = LangEngine::getTranslation($textId);
		$i=1;
		$args = func_get_args();
		$search = array();
		$replace = array();
		while(strpos($str, "[$i]")!==false)
		{
			$search[] = "[$i]";
			if(isset($args[$i]))
			{
				$replace[] = $args[$i];
			}
			else
			{
				$replace[] = "";
			}
			$i++;
		}
		$str = str_replace($search, $replace, $str);
		return $str;
	}
	
	/**
	 * i18n date
	 * @param int Unix timestamp
	 * @return string
	 */
	function __date($timestamp)
	{
		if(!$timestamp)
		{
			return "-";
		}
		
		$return=__("date_long", 
					__( strtolower(date("l", $timestamp)) ),             // Day name
					__( strtolower(date("F", $timestamp)) ),             // Month name
					    date("j", $timestamp),                           // Day number
					__( "date_ordinal_suffix", date("S", $timestamp) ),  // Suffix
					    date("Y", $timestamp)                            // Year
					);					
		
		if($return=="date_long")
		{
			return date("Y/M/j", $timestamp);
		}
		else
		{
			return $return;
		}
	}
	
else:
	
	function __($message)
	{
		return $message;
	}
	
	function __date($timestamp)
	{
		return date("Y/M/j", $timestamp);
	}

endif;

?>
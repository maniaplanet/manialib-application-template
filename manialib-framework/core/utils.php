<?php
/**
 * Functions
 * 
 * @author Maxime Raoust
 */

/**
 * Autoloading function
 */
function __autoload($className)
{
	if (file_exists($path = APP_API_PATH . "$className.class.php"))
	{
		require_once ($path);
		return true;
	}
	elseif(file_exists($path = APP_API_PATH . "gui/cards/$className.class.php"))
	{
		require_once ($path);
		return true;
	}
	elseif(autoload_recursive($className, APP_LIBRARIES_PATH))
	{
		return true;
	}
}

/**
 * Recursive autoloading
 */
function autoload_recursive($className, $path)
{
	if(file_exists($rpath = $path . "/" . $className . ".class.php"))
	{
		require_once($rpath);
		return true;
	}
	$return = false;
	if ($handle = opendir($path))
	{
		while (false !== ($file = readdir($handle)))
		{
			if (strcasecmp(substr($file, 0, 1), "."))
			{
				if(is_dir($path . $file))
				{
					if(autoload_recursive($className, $path . $file))
					{
						return true;
					}
				}
			}
		}
		closedir($handle);
	}
	return false;
} 

/**
 * i18n message
 * 
 * examples
 * echo __("hello_world");
 * echo __("hello_login", $yetAnotherLogin);
 * 
 * @param String $TextId
 * @param Mixed $param...
 * @return String
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
 * 
 * @param Int $timestamp
 * @return String
 */
function __date($timestamp)
{
	if(!$timestamp)
	{
		return "-";
	}
	
	$return=__("date_long", 
				__( strtolower(date("l", $timestamp)) ), 				// Day name
				__( strtolower(date("F", $timestamp)) ), 				// Month name
				    date("j", $timestamp),  							// Day number
				__( "date_ordinal_suffix", date("S", $timestamp) ),		// Suffix
				    date("Y", $timestamp)								// Year
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

/**
 * Writes a message in the debug log file
 */
function debuglog($msg, $addDate = true, $log = DEBUG_LOG)
{
	if ($addDate)
	{
		$msg = date('d/m/y H:i:s') . " $msg\n";
	}
	file_put_contents($log, $msg, FILE_APPEND);
}

/**
 * Triggers a warning
 */
function trigger_warning($message)
{
	trigger_error($message, E_USER_WARNING);
}

/**
 * "Safely" get an element from an array.
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
 * Protect TM styles to put a formatted text in the middle of a sentence
 */
function protectStyles($string)
{
	return "\$<$string\$>";
}

/**
 * Unprotect the TM styles
 */
function unprotectStyles($string)
{
	return str_replace(array (
		'$<',
		'$>'
	), "", $string);
}

/**
 * Remove the TM font styles (wide, bold, underline)
 */
function stripWideFonts($str)
{
	return str_replace(array (
		'$w',
		'$o',
		'$s'
	), "", $str);
}

/**
 * Remove the TM links
 */
function stripLinks($str)
{
	return preg_replace('/\\$[hlp](.*?)(?:\\[.*?\\](.*?))*(?:\\$[hlp]|$)/ixu', '$1$2', $str);
}

/**
 * Include all the files of the given directory
 */
function require_once_dir($directory_path)
{
	if ($handle = opendir($directory_path))
	{
		while (false !== ($file = readdir($handle)))
		{
			if (strcasecmp(substr($file, 0, 1), "."))
			{
				require_once ($directory_path . $file);
			}
		}
		closedir($handle);
	}
}

/**
 * Safe division. Returns 0 if the denominator is 0
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
 * Custom error handler
 */
function manialinkErrorHandler($errno, $errstr, $errfile, $errline)
{
	$session = SessionEngine :: getInstance();
	$request = RequestEngine :: getInstance();
	switch ($errno)
	{
		case E_USER_WARNING :
			$msg = date('d/m/y H:i:s') . " [warning] ";
			$msg .= $errstr . " ";
			$msg .= "at url " . $request->createLink() . "\n";
			error_log(($msg), 3, ERROR_LOG);
			break;
		default :
			
			Manialink::load();

			$ui = new Panel(50, 20);
			$ui->setAlign("center", "center");
			$ui->title->setStyle("TextTitleError");
			$ui->titleBg->setSubStyle("BgTitle2");
			$ui->title->setText(__("fatal_error"));
			$ui->save();

			$ui = new Label(124);
			$ui->enableAutonewline();
			$ui->setAlign("center", "center");
			$ui->setPosition(0, 0, 2);

			$ui->setText(__("error_message"));
			$ui->save();

			$ui = new Button;
			$ui->setText(__("error_back_button"));
			$request = RequestEngine :: getInstance();
			$ui->setManialink($request->createLinkArgList("index.php"));
			$ui->setPosition(0, -3, 5);
			$ui->setHalign("center");
			$ui->save();

			Manialink::render();
	
			$msg = date('d/m/y H:i:s') . " [error] ";
			$msg .= $errstr . " ";
			$msg .= "at url " . $request->createLink() . " ";
			$msg .= $errno . " ";
			$msg .= "in file " . $errfile . " ";
			$msg .= "on line " . $errline . "\n";
			error_log(($msg), 3, ERROR_LOG);
			exit;
			break;
	}
}

/**
 * Custom error handler debug
 */
function manialinkErrorHandlerDebug($errno, $errstr, $errfile, $errline)
{
	$session = SessionEngine :: getInstance();
	$request = RequestEngine :: getInstance();
	switch ($errno)
	{
		case E_USER_WARNING :
			$msg = date('d/m/y H:i:s') . " [warning] ";
			$msg .= $errstr . " ";
			$msg .= "at url " . $request->createLink() . "\n";
			error_log(($msg), 3, ERROR_LOG);
			break;
		default :
			$msg = date('d/m/y H:i:s') . " [error] ";
			$msg .= $errstr . " ";
			$msg .= "at url " . $request->createLink() . " ";
			$msg .= $errno . " ";
			$msg .= "in file " . $errfile . " ";
			$msg .= "on line " . $errline . "\n";
			error_log(($msg), 3, ERROR_LOG);
			
			ob_clean();
	
			Manialink::load();

			$ui = new Panel(115, 85);
			$ui->setAlign("center", "center");
			$ui->titleBg->setSubStyle("BgTitle2");
			$ui->title->setStyle("TextTitleError");
			$ui->title->setText("Fatal Error");
			$ui->save();
			
			$ui = new Label(110);
			$ui->setAlign("center", "center");
			$ui->setPositionZ(1);
			$ui->enableAutonewline();
			$ui->setText($msg);
			$ui->save();

			$ui = new Button;
			$ui->setText(__("error_back_button"));
			$request = RequestEngine :: getInstance();
			$ui->setManialink($request->createLinkArgList("index.php"));
			$ui->setPosition(0, -35, 5);
			$ui->setHalign("center");
			$ui->save();

			Manialink::render();

			exit;
			break;
	}
}

?>
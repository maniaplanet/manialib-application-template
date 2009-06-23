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
	if (file_exists($path = APP_CORE_PATH . "/api/$className.class.php"))
	{
		require_once ($path);
	}
	elseif (file_exists($path = APP_LIBRARIES_PATH . "/$className.class.php"))
	{
		require_once ($path);
	}
}
spl_autoload_register("__autoload");

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
function debuglog($msg, $addDate = true, $log = MANIALINK_DEBUG_LOG)
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
	$link = LinkEngine :: getInstance();
	switch ($errno)
	{
		case E_USER_WARNING :
			$msg = date('d/m/y H:i:s') . " [warning] ";
			$msg .= $errstr . " ";
			$msg .= "at url " . $link->createLink() . "\n";
			error_log(htmlspecialchars_decode($msg), 3, ERROR_LOG);
			break;
		default :
			ob_clean();
	
			$ui = new Manialink;
			$ui->draw();

			$ui = new Panel(50, 20);
			$ui->setAlign("center", "center");
			$ui->title->setStyle("TextTitleError");
			$ui->titleBg->setSubStyle("BgTitle2");
			$ui->title->setText(__("fatal_error"));
			$ui->draw();

			$ui = new Label(124);
			$ui->enableAutoNewLine();
			$ui->setAlign("center", "center");
			$ui->setPosition(0, 0, 2);

			$ui->setText(__("error_message"));
			$ui->draw();

			$ui = new Button;
			$ui->setText(__("error_back_button"));
			$link = LinkEngine :: getInstance();
			$link->resetParams();
			$ui->setManialink($link->createLink("index.php"));
			$ui->setPosition(0, -3, 5);
			$ui->setHalign("center");
			$ui->draw();

			Manialink :: theEnd();
	
			$msg = date('d/m/y H:i:s') . " [error] ";
			$msg .= $errstr . " ";
			$msg .= "at url " . $link->createLink() . " ";
			$msg .= $errno . " ";
			$msg .= "in file " . $errfile . " ";
			$msg .= "on line " . $errline . "\n";
			error_log(htmlspecialchars_decode($msg), 3, ERROR_LOG);
			exit;
			break;
	}
}

set_error_handler("manialinkErrorHandler");
error_reporting(E_ALL);
?>
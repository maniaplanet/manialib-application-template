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

namespace ManiaLib\I18n
{
/**
 * Internationalization
 * 
 * ManiaLib provides a simple way to internationalize your application. The good
 * news is it uses the same dictionary format as the dictionary feature implemented
 * in ManiaLinks. The advantage of using the internationalization features of 
 * ManiaLib over classic Manialink dictionaries is the ability of making dynamic
 * sentences (eg. "Hello 'login'!" where login is from a variable).
 * 
 * How to use it?
 * 
 * First, make sure that the parameter "lang" is in the session. To achieve that,
 * you need to use a link with "addplayerid" and then save the parameter in the 
 * session. If you use the MVC framework, you can add the RegisterRequestParametersFilter
 * to your controller (it will look for the lang parameter in the URL and save
 * it automatically in the session).
 * 
 * Then, put your dictionary files in the public/langs directory. You must use
 * same structure as classic Manialink dictionary, but you can add placeholders
 * for variables using '[1]', '[2]', etc. (without the quotes).
 * 
 *  <code>
 *  <?xml version="1.0"?>
 *  <dico>
 *      <language id="en">
 *          <hello_world>Hello World!</hello_world>
 *          <hello_login>Hello [1] !</hello_login>
 *          <the_xx_is_yy>The [1] is [2].</the_xx_is_yy>
 *      </language>
 *  </dico>
 *  </code>
 *  
 *  Then you can use the translations in your views using the __() function:
 *  
 *  <code>
 *  __("hello_world"); // returns "Hello world!"
 *  __("hello_login", "gou1"); // Returns "Hello gou1!"
 *  __("the_xx_is_yy", "car", "blue"); // Returns "The car is blue."
 *  __("Bla bla bla"); // Returns "Bla bla bla", ie. the word ID itself when it is not found.
 *  </code>
 *  
 *  You can also internationalize dates:
 *  
 *  <code>
 *  $timestamp = time();
 *  __date($timestamp); // Returns, for example: "Friday, July 3rd 2009"
 *  </code>
 */
class I18n
{
	protected static $instance;
	
	protected $currentLang = "en";
	
	/**
	 * Get the translation of the given text ID
	 */
	public static function getTranslation($textId)
	{
		if(\ManiaLib\Config\Loader::$config->i18n->dynamic)
		{
			return self::getInstance()->getTranslationPrivate($textId);
		}
		else
		{
			return $textId;
		}
	}
		
	/**
	 * @return \ManiaLib\I18n\I18n
	 */
	public static function getInstance()
	{
		if (!self::$instance)
		{
			$class = __CLASS__;
			self::$instance = new $class();
		}
		return self::$instance;
	}

	protected function __construct()
	{
		if(\ManiaLib\Config\Loader::$config->i18n->dynamic)
		{
			$session = \ManiaLib\Session\Session::getInstance();
			$this->currentLang = $session->get("lang", "en");
		}
	}
	
	/**
	 * Get the transaltion of the given text ID
	 * @return string
	 */
	protected function getTranslationPrivate($textId, $lang=null)
	{
		if(!$lang)
		{
			$lang = $this->currentLang;
		}
		if(isset(Loader::$dico[$lang][$textId]))
		{
			return Loader::$dico[$lang][$textId];
		}	
		elseif(isset(Loader::$dico["en"][$textId]))
		{
			return Loader::$dico["en"][$textId];
		}
		else
		{
			return $textId;
		}
	}
}
}

namespace 
{
/**
 * i18n message
 * 
 * To use with dynamic mode
 * 
 * Example:
 * <code> 
 * echo __("hello_world"); 
 * echo __("hello_login", $someLogin);
 * </code>
 * @param string
 * @return string
 */
function __($textId)
{
	$str = \ManiaLib\I18n\I18n::getTranslation($textId);
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
	
}

?>
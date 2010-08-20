<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib_MVC
 */

if(class_exists('GettextInitFilterConfig', false))
{
	/**
	 * Gettext init config
	 * 
	 * Redeclare this class in your config in you want to override values
	 * 
	 * @package ManiaLib_MVC
 	 * @subpackage DefaultFilters
	 */
	abstract class GettextInitFilterConfig
	{
		static $supportedLocales = array(
		'en' => 'en_US'
		);
		
		static $defaultLang = 'en';
		static $encoding = 'UTF-8';
		static $domain = 'messages';
	}
}

/**
 * Gettext init
 * 
 * Init the "gettext" extension if you want to used it. For advanced users only.
 * 
 * @package ManiaLib_MVC
 * @subpackage DefaultFilters
 */
class GettextInitFilter extends AdvancedFilter
{
	function preFilter()
	{
		if(ENABLE_GETTEXT_INIT)
		{
			$locale = $this->session->get('lang', GettextInitFilterConfig::$defaultLang);
			if(!array_key_exists($locale, GettextInitFilterConfig::$supportedLocales))
			{
				$locale = GettextInitFilterConfig::$defaultLang;
			}	
			setlocale(LC_MESSAGES, GettextInitFilterConfig::$supportedLocales[$locale]);
			bindtextdomain(GettextInitFilterConfig::$domain, APP_LOCALE_PATH);
			if(function_exists("bind_textdomain_codeset"))
			{
				bind_textdomain_codeset(GettextInitFilterConfig::$domain, GettextInitFilterConfig::$encoding);
			}
			textdomain(GettextInitFilterConfig::$domain);
		}
	}
	
	function postFilter() {}
}

?>
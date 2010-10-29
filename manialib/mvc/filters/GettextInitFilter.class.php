<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 * @subpackage MVC_DefaultFilters
 */

if(class_exists('GettextInitFilterConfig', false))
{
	/**
	 * Gettext init config
	 * Redeclare this class in your config in you want to override values
	 * @package ManiaLib
 	 * @subpackage MVC_DefaultFilters
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
 * Init the "gettext" extension if you want to used it. For advanced users only.
 * Not that gettext doesn't work with HipHop for PHP
 * @package ManiaLib
 * @subpackage MVC_DefaultFilters
 */
class GettextInitFilter extends AdvancedFilter
{
	/**
	 * @ignore
	 */
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
	
	/**
	 * @ignore
	 */
	function postFilter() {}
}

?>
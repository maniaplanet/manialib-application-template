<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 *
 * @see         http://code.google.com/p/manialib/
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\Utils;

/*
 * Info: pattern (?<!\$)((?:\$\$)*) match an even number of $
 */
abstract class Formatting
{

	/**
	 * Removes wide, bold and shadowed
	 */
	static function stripWideFonts($string)
	{
		return preg_replace('/(?<!\$)((?:\$\$)*)\$[wos]/iu', '$1', $string);
	}

	/**
	 * Removes links
	 */
	static function stripLinks($string)
	{
		return preg_replace('/(?<!\$)((?:\$\$)*)\$[hlp](?:\[.*?\])?(.*?)(?:\$[hlp]|$)/iu', '$1$2', $string);
	}

	/**
	 * Removes colors
	 */
	static function stripColors($string)
	{
		return preg_replace('/(?<!\$)((?:\$\$)*)\$(?:g|[0-9a-f].{2})/iu', '$1', $string);
	}

	/**
	 * Removes all styles
	 */
	static function stripStyles($string)
	{
		$string = preg_replace('/(?<!\$)((?:\$\$)*)\$[^$0-9a-hlp]/iu', '$1', $string);
		$string = self::stripLinks($string);
		$string = self::stripColors($string);
		return $string;
	}

}

?>
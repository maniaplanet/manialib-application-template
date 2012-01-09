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

abstract class Formatting
{

	/**
	 * Removes wide, bold and shadowed
	 */
	static function stripWideFonts($string)
	{
		return str_ireplace(array('$w', '$o', '$s'), "", $string);
	}

	/**
	 * Removes links
	 */
	static function stripLinks($string)
	{
		return preg_replace(
				'/\\$[hlp](.*?)(?:\\[.*?\\](.*?))?(?:\\$[hlp]|$)/ixu', '$1$2', $string);
	}

	/**
	 * Removes colors
	 */
	static function stripColors($string)
	{
		return preg_replace(
				'/\\$([tinmgz]|[0-9a-fA-F]{3}|[0-9a-fA-F].{2}|[0-9a-fA-F].[0-9a-fA-F]|[0-9a-fA-F]{2}.|[^$hlpwos<>]?)/iu',
				"", $string);
	}

	/**
	 * Removes all styles
	 */
	static function stripStyles($string)
	{
		$string = preg_replace('/([^\$])(\$>|\$<)/u', '$1', $string);
		$string = self::stripLinks($string);
		$string = self::stripWideFonts($string);
		$string = self::stripColors($string);
		return $string;
	}

}

?>
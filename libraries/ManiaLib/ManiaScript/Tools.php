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

namespace ManiaLib\ManiaScript;

/**
 * This is a BETA PHP abstraction of the ManiaScript framework, so the warning 
 * in the latter still applies:
 * 
 * This framework is not finished, not documented, not very useful and quite 
 * possibly full of bugs. We'll also probably break everything at some point to
 * refactor the code. However it's LGPL, so you can use at your own risk :)
 */
abstract class Tools
{

	/**
	 * Returns a escaped and quoted string so you can use it a func param.
	 * Eg. if you pass ubisoft"nadeo il will return "ubisoft\"nadeo"
	 * @return string
	 */
	static function quote($string)
	{
		return sprintf('"%s"', self::escapeString($string));
	}

	static function escapeString($string)
	{
		return addcslashes($string, '"\\');
	}

}

?>
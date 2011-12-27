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

namespace ManiaLib\ManiaScript;

use ManiaLib\Gui\Manialink;

/**
 * This is a BETA PHP abstraction of the ManiaScript framework, so the warning 
 * in the latter still applies:
 * 
 * This framework is not finished, not documented, not very useful and quite 
 * possibly full of bugs. We'll also probably break everything at some point to
 * refactor the code. However it's LGPL, so you can use at your own risk :)
 */
abstract class Manipulation
{

	static function hide($controlId)
	{
		$script = 'manialib_hide("%s"); ';
		$controlId = Tools::escapeString($controlId);
		$script = sprintf($script, $controlId);
		Manialink::appendScript($script);
	}

	static function show($controlId)
	{
		$script = 'manialib_hide("%s"); ';
		$controlId = Tools::escapeString($controlId);
		$script = sprintf($script, $controlId);
		Manialink::appendScript($script);
	}

	static function toggle($controlId)
	{
		$script = 'manialib_hide("%s"); ';
		$controlId = Tools::escapeString($controlId);
		$script = sprintf($script, $controlId);
		Manialink::appendScript($script);
	}

}

?>
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
 * @see http://code.google.com/p/manialib/source/browse/trunk/media/maniascript/manialib.xml
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
		$script = 'manialib_show("%s"); ';
		$controlId = Tools::escapeString($controlId);
		$script = sprintf($script, $controlId);
		Manialink::appendScript($script);
	}

	static function toggle($controlId)
	{
		$script = 'manialib_toggle("%s"); ';
		$controlId = Tools::escapeString($controlId);
		$script = sprintf($script, $controlId);
		Manialink::appendScript($script);
	}

	static function absolutePosx($controlId, $posx)
	{
		$script = 'manialib_absolute_posx("%s", %f); ';
		$controlId = Tools::escapeString($controlId);
		$script = sprintf($script, $controlId, $posx);
		Manialink::appendScript($script);
	}

	static function absolutePosy($controlId, $posy)
	{
		$script = 'manialib_absolute_posy("%s", %f); ';
		$controlId = Tools::escapeString($controlId);
		$script = sprintf($script, $controlId, $posy);
		Manialink::appendScript($script);
	}

	static function absolutePosz($controlId, $posz)
	{
		$script = 'manialib_absolute_posz("%s", %f); ';
		$controlId = Tools::escapeString($controlId);
		$script = sprintf($script, $controlId, $posz);
		Manialink::appendScript($script);
	}

	static function posx($controlId, $posx)
	{
		$script = 'manialib_posx("%s", %f); ';
		$controlId = Tools::escapeString($controlId);
		$script = sprintf($script, $controlId, $posx);
		Manialink::appendScript($script);
	}

	static function posy($controlId, $posy)
	{
		$script = 'manialib_posy("%s", %f); ';
		$controlId = Tools::escapeString($controlId);
		$script = sprintf($script, $controlId, $posy);
		Manialink::appendScript($script);
	}

	static function posz($controlId, $posz)
	{
		$script = 'manialib_posz("%s", %f); ';
		$controlId = Tools::escapeString($controlId);
		$script = sprintf($script, $controlId, $posz);
		Manialink::appendScript($script);
	}

	static function setText($controlId, $text)
	{
		$script = 'manialib_set_text("%s", "%s"); ';
		$controlId = Tools::escapeString($controlId);
		$text = Tools::escapeString($text);
		$script = sprintf($script, $controlId, $text);
		Manialink::appendScript($script);
	}

	static function setEntryValue($controlId, $value)
	{
		$script = 'manialib_set_entry_value("%s", "%s"); ';
		$controlId = Tools::escapeString($controlId);
		$value = Tools::escapeString($value);
		$script = sprintf($script, $controlId, $value);
		Manialink::appendScript($script);
	}

	static function setImage($controlId, $URL)
	{
		$script = 'manialib_set_image("%s", "%s"); ';
		$controlId = Tools::escapeString($controlId);
		$URL = Tools::escapeString($URL);
		$script = sprintf($script, $controlId, $URL);
		Manialink::appendScript($script);
	}

	static function disableLinks()
	{
		$script = 'manialib_disable_links(); ';
		Manialink::appendScript($script);
	}

	static function enableLinks()
	{
		$script = 'manialib_enable_links(); ';
		Manialink::appendScript($script);
	}

}

?>
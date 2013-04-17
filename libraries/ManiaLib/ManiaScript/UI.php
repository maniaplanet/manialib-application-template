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
abstract class UI
{

	/**
	 * Teh infamous dialog box
	 *
	 * @param string $openControlId Id of the element that will open the dialog when clicked
	 * @param string $message Message to show in the dialog
	 * @param array $action A ManiaScript Framework Action
	 */
	static function dialog($openControlId, $message, array $action = array())
	{
		$script = 'manialib_ui_dialog("%s", "%s", %s); ';
		$openControlId = Tools::escapeString($openControlId);
		$message = Tools::escapeString($message);
		$action = Tools::array2maniascript($action);
		$script = sprintf($script, $openControlId, $message, $action);
		Manialink::appendScript($script);
	}

	/**
	 * Teh infamous dialog box
	 *
	 * @param string $openControlId Id of the element that will open the dialog when clicked
	 * @param string $message Message to show in the dialog
	 * @param array $action A ManiaScript Framework Action
	 */
	static function message($openControlId, $message)
	{
		$script = 'manialib_ui_message("%s", "%s"); ';
		$openControlId = Tools::escapeString($openControlId);
		$message = Tools::escapeString($message);
		$script = sprintf($script, $openControlId, $message);
		Manialink::appendScript($script);
	}

	/**
	 * Nice little tooltip when mousing over
	 *
	 * @param string $controlId Id of the element that will be tooltiped
	 * @param string $message
	 */
	static function tooltip($controlId, $message)
	{
		$script = 'manialib_ui_tooltip("%s", "%s"); ';
		$controlId = Tools::escapeString($controlId);
		$message = Tools::escapeString($message);
		$script = sprintf($script, $controlId, $message);
		Manialink::appendScript($script);
	}

	static function datePicker($entryId, $openControlId)
	{
		$script = 'manialib_ui_datepicker_init("%s", "%s");';
		$entryId = Tools::escapeString($entryId);
		$openControlId = Tools::escapeString($openControlId);
		$script = sprintf($script, $entryId, $openControlId);
		Manialink::appendScript($script);
	}

	static function magnifier($imageId, $scale)
	{
		$script = 'manialib_ui_magnifier("%s", "%f"); ';
		$controlId = Tools::escapeString($imageId);
		$script = sprintf($script, $imageId, $scale);
		Manialink::appendScript($script);
	}

}

?>
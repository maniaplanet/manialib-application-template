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
abstract class UI
{

	/**
	 * ATCHUNG: FOR "manialib.xml" ie. FIRST VERSION !
	 * 
	 * Teh infamous dialog box
	 * 
	 * @param string $openControlId Id of the element that will open the dialog when clicked
	 * @param string $message Message to show in the dialog
	 * @param string $actionName Action: manialink, maniazone, external, none
	 * @param string $actionValue
	 */
	static function dialog2($openControlId, $message, $actionName, $actionValue)
	{
		$script = 'manialib_ui_dialog2("%s", "%s", "%s", "%s"); ';
		$openControlId = Tools::escapeString($openControlId);
		$message = Tools::escapeString($message);
		$actionName = Tools::escapeString($actionName);
		$actionValue = Tools::escapeString($actionValue);
		$script = sprintf($script, $openControlId, $message, $actionName, $actionValue);
		Manialink::appendScript($script);
	}

	/**
	 * ATCHUNG: FOR "manialib.xml" ie. FIRST VERSION !
	 * 
	 * Nice little tooltip when mousing over
	 * 
	 * @param string $controlId Id of the element that will be tooltiped
	 * @param string $message
	 */
	static function autotip2($controlId, $message)
	{
		$script = 'manialib_ui_autotip2("%s", "%s"); ';
		$controlId = Tools::escapeString($controlId);
		$message = Tools::escapeString($message);
		$script = sprintf($script, $controlId, $message);
		Manialink::appendScript($script);
	}
	
	
	/**
	 * ATCHUNG: FOR "manialib2.xml" ie. SECOND VERSION !
	 * 
	 * Teh infamous dialog box
	 * 
	 * @param string $openControlId Id of the element that will open the dialog when clicked
	 * @param string $message Message to show in the dialog
	 * @param array $action A ManiaScript Framework Action
	 */
	static function dialog($openControlId, $message, array $action)
	{
		$script = 'manialib_ui_dialog("%s", "%s", %s); ';
		$openControlId = Tools::escapeString($openControlId);
		$message = Tools::escapeString($message);
		$action = Tools::array2maniascript($action);
		$script = sprintf($script, $openControlId, $message, $action);
		Manialink::appendScript($script);
	}
	
	/**
	 * ATCHUNG: FOR "manialib2.xml" ie. SECOND VERSION !
	 * 
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

}

?>
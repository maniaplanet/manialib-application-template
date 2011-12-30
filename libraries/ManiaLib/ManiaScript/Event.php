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
abstract class Event
{
	const mouseClick = 'CGameManialinkScriptEvent::Type::MouseClick';
	const mouseOver = 'CGameManialinkScriptEvent::Type::MouseOver';
	const mouseOut = 'CGameManialinkScriptEvent::Type::MouseOut';

	static function addListener($controlId, $eventType, array $action)
	{
		$script = 'manialib_event_add_listener("%s", %s, %s); ';
		$controlId = Tools::escapeString($controlId);
		$action = Tools::array2maniascript($action);
		$script = sprintf($script, $controlId, $eventType, $action);
		Manialink::appendScript($script);
	}

}

?>
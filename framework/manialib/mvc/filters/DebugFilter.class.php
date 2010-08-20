<?php
/**
 * @author Philippe Melot 
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib_MVC
 */

/**
 * Debug filter
 * 
 * Restricts users that can access the Manialink (for debugging purpose only)
 * 
 * @package ManiaLib_MVC
 * @subpackage DefaultFilters
 */
class DebugFilter extends AdvancedFilter
{
	function preFilter()
	{
		if(APP_DEBUG_LEVEL && defined('AUTHORIZED_USERS'))
		{
			$session = SessionEngine::getInstance();
			if(!in_array($session->get('login'),explode(',',AUTHORIZED_USERS)))
			{
				$request = RequestEngineMVC::getInstance();
				$request->redirectManialinkAbsolute('manialink:home');
			}
		}
	}
}

?>
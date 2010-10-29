<?php
/**
 * @author Philippe Melot 
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 * @subpackage MVC_DefaultFilters
 */

/**
 * Debug filter
 * Restricts users that can access the Manialink (for debugging purpose only)
 * @package ManiaLib
 * @subpackage MVC_DefaultFilters
 */
class DebugFilter extends AdvancedFilter
{
	/**
	 * @ignore
	 */
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
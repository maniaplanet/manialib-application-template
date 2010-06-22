<?php
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
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

namespace ManiaLib\Application\Filters;

/**
 * Register usual paramaters such as login, nickname etc. so that you only need 
 * to access them through the session
 */
class RegisterRequestParameters extends \ManiaLib\Application\AdvancedFilter
{
	function preFilter()
	{		
		if(!$this->session->login)
		{
			if($login = $this->request->get('playerlogin'))
			{
				$this->session->login = $login;
			}
			elseif($login = $this->request->get('login'))
			{
				$this->session->login = $login;
			}
		}
		
		if(!$this->session->nickname)
		{
			if($nickname = $this->request->get('nickname'))
			{
				$this->session->nickname = $nickname;
			}
		}
		
		if(!$this->session->path)
		{
			if($path = $this->request->get('path'))
			{
				$this->session->path = $path;
			}
		}
		
		if(!$this->session->lang)
		{
			if($lang = $this->request->get('lang'))
			{
				$this->session->lang = $lang;
			}
		}
		
		if(!$this->session->token)
		{
			if($token = $this->request->get('token'))
			{
				$this->session->token = $token;
			}
		}

		if(!$this->session->game)
		{
			if($game = $this->request->get('game'))
			{
				$this->session->game = $game;
			}
		}
		
		$this->request->delete('login');
		$this->request->delete('playerlogin');
		$this->request->delete('nickname');
		$this->request->delete('path');
		$this->request->delete('lang');
		$this->request->delete('token');
		$this->request->delete('game');
	}
	
	function postFilter() {}
}

?>
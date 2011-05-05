<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2664 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-02-25 18:34:08 +0100 (ven., 25 févr. 2011) $:
 */

namespace ManiaLib\Authentication\Web;

use ManiaLib\Application\Route;

class Filter extends \ManiaLib\Authentication\AbstractFilter
{
	static function isLoggedIn()
	{
		$session = \ManiaLib\Session\Session::getInstance();
		return $session->get(static::SESS_AUTH_KEY);
	}
	
	static function logout()
	{
		$session = \ManiaLib\Session\Session::getInstance();
		$session->delete(static::SESS_AUTH_KEY);
		$session->delete('login');
		$session->delete('token');
	}
	
	protected function redirectToLogin()
	{
		$params['application'] = \ManiaLib\Authentication\Config::getInstance()->username;
		$params['redirection'] = $this->request->createLink(Route::CUR, Route::CUR);
		
		$url = 'https://player.trackmania.com/';
		$url = $url.'?'.http_build_query($params);
		
		$this->request->redirectWebAbsolute($url);
	}
}

?>
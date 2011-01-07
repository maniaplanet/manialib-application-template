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
 * Register request parameters
 * Register usual paramaters such as login, nickname etc. so that you only need 
 * to access them through the \ManiaLib\Session\Session
 * Example:
 * If your enable this extension, to retrieve the login of the current user you
 * only have to do:
 * <code>
 * $session = \ManiaLib\Session\Session::getInstance();
 * //...
 * $session->get('login');
 * </code>
 */
class RegisterRequestParameters extends \ManiaLib\Application\AdvancedFilter
{
	/**
	 * @ignore
	 */
	function preFilter()
	{		
		if($playerLogin = $this->request->get('playerlogin'))
		{
			$this->session->set('login', $playerLogin);
		}
		$this->request->registerProtectedParam('playerlogin');
		$this->request->registerGlobalParam('login');
		$this->request->registerGlobalParam('nickname');
		$this->request->registerGlobalParam('path');
		$this->request->registerGlobalParam('lang');
		$this->request->registerGlobalParam('token');
		$this->request->registerGlobalParam('sess');
		$this->request->registerGlobalParam('game');
		
		if ($redirect = $this->request->get('redirect'))
		{
			$this->request->delete('redirect');
			$redirect = explode('/', $redirect);
			$this->request->redirectManialink($redirect[0], $redirect[1]);
		}
	}
	
	/**
	 * @ignore
	 */
	function postFilter() {}
}

?>
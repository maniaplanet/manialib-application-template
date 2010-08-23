<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib_MVC
 * @subpackage DefaultFilters
 */

/**
 * Register request parameters
 * 
 * Register usual paramaters such as login, nickname etc. so that you only need 
 * to access them through the SessionEngine
 * 
 * Example:
 * If your enable this extension, to retrieve the login of the current user you
 * only have to do:
 * <code>
 * $session = SessionEngine::getInstance();
 * //...
 * $session->get('login');
 * </code>
 * 
 * @package ManiaLib_MVC
 * @subpackage DefaultFilters
 */
class RegisterRequestParametersFilter extends AdvancedFilter
{
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
	}
	
	function postFilter() {}
}

?>
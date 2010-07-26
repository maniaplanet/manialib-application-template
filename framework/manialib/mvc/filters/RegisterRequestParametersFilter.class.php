<?php
/**
 * @author Maxime Raoust
 */

/**
 * Register usual paramaters such as login, nickname etc. 
 * so that you only need to access them through the SessionEngine 
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
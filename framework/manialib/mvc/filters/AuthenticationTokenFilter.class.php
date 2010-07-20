<?php
/**
 * 
 * @author Philippe Melot
 * @copyright Nadeo (c) 2010
 *
 */

class AuthenticationTokenFilter extends AdvancedFilter
{
	function preFilter()
	{
		if(!$this->session->exists('isAuthentified'))
		{
			try
			{
				$playerlogin = $this->request->get('playerlogin');
				if(!$playerlogin)
				{
					$playerlogin = $this->session->getStrict('login');
				}

				$token = $this->request->get('token');
				if(!$token)
				{
					$token = $this->session->getStrict('token');
				}
				
				if(AuthenticationToken::checkAuthenticationToken($playerlogin, $token))
					$this->session->set('isAuthentified',1);
					
				$this->session->delete('token');
			}
			catch (AuthenticationTokenFailedException $e)
			{
				$this->request->redirectManialinkAbsolute('Manialink:Home');
			}
		}
	}

	function postFilter() {}
}
?>
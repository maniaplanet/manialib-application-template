<?php
/**
 * @author Philippe Melot 
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib_MVC
 * @subpackage DefaultFilters
 */

/**
 * Authentication filter
 * 
 * Register this filter in your controller, and all the actions will require 
 * authentication using the Manialink Authentication System developped by NADEO
 * 
 * @see AuthenticationToken 
 * @package ManiaLib_MVC
 * @subpackage DefaultFilters
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
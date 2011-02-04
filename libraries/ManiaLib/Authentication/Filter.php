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

namespace ManiaLib\Authentication;

/**
 * Authentication filter
 * Register this filter in your controller, and all the actions will require 
 * authentication using the Manialink Authentication System developped by NADEO
 * @see \ManiaLib\Authentication\Authentication 
 */
class Filter extends \ManiaLib\Application\AdvancedFilter
{
	const SESSION_ISAUTH = 'mlauth_isauth';
	const SESSION_TRIED = 'mlauth_tried';
	
	/**#@+
	 * @ignore
	 */
	protected static $onFailureCallback;
	protected static $onFailureCallbackParameters;
	/**#@-*/
	
	protected $shortManialink;
	
	static function setOnFailureCallback($callback)
	{
		self::$onFailureCallback = $callback;
	}
	
	static function setOnFailureCallbackParameters(array $parameters)
	{
		self::$onFailureCallbackParameters = $parameters;
	}
	
	/**
	 * @ignore
	 */
	function preFilter()
	{
		if(!$this->session->exists(self::SESSION_ISAUTH))
		{
			if(!$this->session->get(self::SESSION_TRIED, false))
			{
				$this->session->set(self::SESSION_TRIED, true);
				if(!$this->shortManialink)
				{
					if(\ManiaLib\Config\Loader::$config->application)
					{
						if($ml = \ManiaLib\Config\Loader::$config->application->manialink)
						{
							$this->shortManialink = $ml;
						}
					}
				}
				
				$params = $_GET;
				$params['authentication'] = 1;
				$params['redirect'] = $this->request->getController() . '/' . $this->request->getAction();

				$this->request->redirectManialinkAbsolute($this->shortManialink.'?'.http_build_query($params, '', '&'));
			}
			
			try
			{
				$login = $this->session->getStrict('login');
				$token = $this->session->getStrict('token');
				Authentication::checkAuthenticationToken($login, $token);
				$this->session->set(self::SESSION_ISAUTH, 1);
				$this->session->delete('token');
				$this->request->delete('authentication');
			}
			catch (\Exception $e)
			{
				if(self::$onFailureCallback)
				{
					$callback = self::$onFailureCallback;
					$parameters = self::$onFailureCallbackParameters;
				} 
				else 
				{
					$callback = array($this->request, 'redirectManialinkAbsolute');
					$parameters = array('Manialink:home');
				}

				call_user_func_array($callback, $parameters);
			}
		}
	}

	/**
	 * @ignore
	 */
	function postFilter() {}
}
?>
<?php
/**
 * @author Philippe Melot 
 * @copyright 2009-2010 NADEO 
 */

/**
 * Authentication filter
 * Register this filter in your controller, and all the actions will require 
 * authentication using the Manialink Authentication System developped by NADEO
 * @see ManiaLib_Authentication_Authentication 
 */
class ManiaLib_Authentication_Filter extends ManiaLib_Application_AdvancedFilter
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
					if(ManiaLib_Config_Loader::$config->application)
					{
						if($ml = ManiaLib_Config_Loader::$config->application->manialink)
						{
							$this->shortManialink = $ml;
						}
					}
				}
				$this->request->redirectManialinkAbsolute($this->shortManialink.'?authentication=1');
			}
			
			try
			{
				ManiaLib_Log_Logger::info($_GET);
				$login = $this->session->getStrict('login');
				$token = $this->session->getStrict('token');
				ManiaLib_Authentication_Authentication::checkAuthenticationToken($login, $token);
				$this->session->set(self::SESSION_ISAUTH, 1);
				$this->session->delete('token');
			}
			catch (Exception $e)
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

				//call_user_func_array($callback, $parameters);
				
				// FIXME Put a better callback here
				throw new ManiaLib_Application_UserException
					('This manialink is only available to United Forever players');
			}
		}
	}

	/**
	 * @ignore
	 */
	function postFilter() {}
}
?>
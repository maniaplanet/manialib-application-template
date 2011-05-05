<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2776 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-03-04 15:34:01 +0100 (ven., 04 mars 2011) $:
 */

namespace ManiaLib\Authentication;

use ManiaLib\Application\SilentUserException;

/**
 * Authentication abstract filter
 */
abstract class AbstractFilter extends \ManiaLib\Application\AdvancedFilter
{
	const SESS_AUTH_KEY = 'manialib-auth';
	
	protected $forceUnited;
	
	function __construct($forceUnited = false)
	{
		parent::__construct();
		$this->forceUnited = $forceUnited;
	}
	
	function preFilter()
	{
		if($this->session->get(static::SESS_AUTH_KEY))
		{
			return;		
		}
		
		if(!$this->session->token)
		{
			$this->redirectToLogin();
			return;
		}
			
		try
		{
			$login = $this->session->login;
			$token = $this->session->token;
			
			$authClassname = explode('\\', get_called_class());
			array_pop($authClassname);
			$authClassname = implode('\\', $authClassname);
			$authClassname .= '\\Authentication';
			
			call_user_func(array($authClassname, 'checkAuthenticationToken'), $login, $token);
			$this->session->game = call_user_func(array($authClassname, 'getGame'));
			if($this->forceUnited)
			{
				if($this->session->game != 'united')
				{
					$this->response->errorManialink = 'manialink:home';
					throw new SilentUserException(
						'You need a TrackMania United account to access this Manialink.');
				}
			}
			$this->session->set(static::SESS_AUTH_KEY, 1);
			$this->request->delete('authentication');
			
			\ManiaLib\Log\Logger::info(sprintf('%s logged in', $login));
		}
		catch (\Exception $e)
		{
			$this->request->delete('authentication');
			$this->session->delete('token');
			$this->session->delete(static::SESS_AUTH_KEY);
			
			if($e instanceof SilentUserException)
			{
				throw $e;
			}
			elseif($e instanceof \ErrorException)
			{
				throw $e;
			}
			elseif($e instanceof \ManiaLib\Authentication\Exception)
			{
				$message = 'Authentication failed: '.$e->getMessage();
			}
			else
			{
				$message = 'Authentication failed';
			}
			throw new \ManiaLib\Application\UserException($message);
		}
	}
	
	abstract protected function redirectToLogin();
}

?>
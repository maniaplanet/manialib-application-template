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

/**
 * Authentication abstract filter
 */
abstract class AbstractFilter extends \ManiaLib\Application\AdvancedFilter
{
	const SESS_AUTH_KEY = 'manialib-auth';
	const SESS_AUTH_ERROR = 'manialib-auth-error';
	
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
		
		if($message = $this->session->get(static::SESS_AUTH_ERROR))
		{
			throw new \ManiaLib\Application\UserException($message);
		}
		
		if(!$this->request->exists('token'))
		{
			$this->redirectToLogin();
			return;
		}
			
		try
		{
			$login = $this->session->login;
			$token = $this->request->get('token');
			
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
					throw new \ManiaLib\Application\UserException(
						'You need a United account to access this Manialink');
				}
			}
			$this->session->login = $login;
			$this->session->set(static::SESS_AUTH_KEY, 1);
			$this->request->delete('token');
			$this->request->delete('authentication');
			
			// FIXME MANIALIB Find a better way to do that (events?)
			\ManiaLib\Log\Logger::info(sprintf('%s logged in', $login));
		}
		catch (\Exception $e)
		{
			$this->request->delete('token');
			$this->request->delete('authentication');
			if($e instanceof \ManiaLib\Application\UserException)
			{
				$this->session->set(static::SESS_AUTH_ERROR, $e->getMessage());
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
			$this->session->set(static::SESS_AUTH_ERROR, $message);
			throw new \ManiaLib\Application\UserException($message);
		}
	}
	
	abstract protected function redirectToLogin();
}
?>
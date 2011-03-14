<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2751 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-03-04 12:09:25 +0100 (ven., 04 mars 2011) $:
 */

namespace ManiaLib\Authentication;

abstract class AbstractAuthentication
{
	protected static $game;
	
	/**
	 * Check if the login and the token are correct for the authentication
	 * 
	 * @param string
	 * @param string
	 * @throws NoLoginException
	 * @throws InvalidTokenException
	 * @throws InvalidLoginException
	 * @throws UnkownPlayerException
	 * @throws BadTokenException
	 * @throws Exception
	 */
	static function checkAuthenticationToken($login, $token)
	{
		if(!$login)
			throw new NoLoginException('Login is empty');
			
		if(!$token)
			throw new InvalidTokenException('Token is empty');
		
		$response = static::executeRequest($login, $token);
		$matches = null;
		preg_match('/<error>([0-9]+)<\/error>/i', $response, $matches);
		if(array_key_exists(1, $matches))
		{
			$error = $matches[1];
			switch($error)
			{
				case 7:   throw new InvalidLoginException('Invalid login');
				case 14:  throw new UnkownPlayerException('Unknown player');
				case 166: throw new InvalidTokenException('Invalid token');
				case 167: throw new BadTokenException('Bad token');
				default:  throw new Exception('Internal error');
			}
		}
		
		$matches = null;
		preg_match('/<accounttype>(.*)<\/accounttype>/i', $response, $matches);
		if(array_key_exists(1, $matches))
		{
			static::$game = $matches[1];
		}
	}
	
	static function getGame()
	{
		if(static::$game === null)
		{
			throw new Exception('No game set. You must use authentication first');
		}
		elseif(!in_array(static::$game, array('nations', 'united')))
		{
			throw new Exception('Unkown game in checkAuthenticationToken response: '.static::$game);
		}
		return static::$game;
	}
	
	static protected function executeRequest($login, $token){}
}

class Exception extends \Exception {}
class InvalidLoginException extends Exception {}
class NoLoginException extends Exception {}
class BadTokenException extends Exception {}
class InvalidTokenException extends Exception {}
class UnkownPlayerException extends Exception {}

?>
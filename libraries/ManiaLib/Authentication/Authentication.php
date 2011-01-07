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
 * Manialink Authentication
 * Helps using the Manialink Authentication System developped by NADEO. 
 * Note that it only works with United Forever accounts.
 */
final class Authentication
{
	const scriptUrl = 'http://scripts.trackmaniaforever.com/checkAuthenticationToken.php?login=%s&token=%s';

	/**
	 * 
	 * Check if the login and the token are correct for the
	 * authentication
	 * 
	 * @param string $playerlogin
	 * @param string $token
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
			throw new NoLoginException();
			
		if(!$token)
			throw new InvalidTokenException();
		
		$scriptUrl = sprintf(self::scriptUrl, $login, $token);
		$response = file_get_contents($scriptUrl);
		$error = strstr('<errors>',$response);
		
		if($error)
		{
			$error = str_split($error, strlen(strstr('</response>', $error)));
			switch($error)
			{
				case 7:   throw new InvalidLoginException();
				case 14:  throw new UnkownPlayerException();
				case 166: throw new InvalidTokenException();
				case 167: throw new BadTokenException();
				default:  throw new Exception();
			}
		}
	}
}

class Exception extends \Exception {}
class InvalidLoginException extends Exception {}
class NoLoginException extends Exception {}
class BadTokenException extends Exception {}
class InvalidTokenException extends Exception {}
class UnkownPlayerException extends Exception {}

?>
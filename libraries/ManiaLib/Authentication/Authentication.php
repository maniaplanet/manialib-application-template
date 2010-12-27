<?php
/**
 * @author Philippe Melot
 * @copyright 2009-2010 NADEO
 */

/**
 * Manialink Authentication
 * Helps using the Manialink Authentication System developped by NADEO. 
 * Note that it only works with United Forever accounts.
 */
final class ManiaLib_Authentication_Authentication
{
	const scriptUrl = 'http://scripts.trackmaniaforever.com/checkAuthenticationToken.php?login=%s&token=%s';

	/**
	 * 
	 * Check if the login and the token are correct for the
	 * authentication
	 * 
	 * @param string $playerlogin
	 * @param string $token
	 * @throws ManiaLib_Authentication_NoLoginException
	 * @throws ManiaLib_Authentication_InvalidTokenException
	 * @throws ManiaLib_Authentication_InvalidLoginException
	 * @throws ManiaLib_Authentication_UnkownPlayerException
	 * @throws ManiaLib_Authentication_BadTokenException
	 * @throws ManiaLib_Authentication_Exception
	 */
	static function checkAuthenticationToken($login, $token)
	{
		if(!$login)
			throw new ManiaLib_Authentication_NoLoginException();
			
		if(!$token)
			throw new ManiaLib_Authentication_InvalidTokenException();
		
		$scriptUrl = sprintf(self::scriptUrl, $login, $token);
		$response = file_get_contents($scriptUrl);
		$error = strstr('<errors>',$response);
		
		if($error)
		{
			$error = str_split($error, strlen(strstr('</response>', $error)));
			switch($error)
			{
				case 7:   throw new ManiaLib_Authentication_InvalidLoginException();
				case 14:  throw new ManiaLib_Authentication_UnkownPlayerException();
				case 166: throw new ManiaLib_Authentication_InvalidTokenException();
				case 167: throw new ManiaLib_Authentication_BadTokenException();
				default:  throw new ManiaLib_Authentication_Exception();
			}
		}
	}
}

class ManiaLib_Authentication_Exception extends Exception {}
class ManiaLib_Authentication_InvalidLoginException extends ManiaLib_Authentication_Exception {}
class ManiaLib_Authentication_NoLoginException extends ManiaLib_Authentication_Exception {}
class ManiaLib_Authentication_BadTokenException extends ManiaLib_Authentication_Exception {}
class ManiaLib_Authentication_InvalidTokenException extends ManiaLib_Authentication_Exception {}
class ManiaLib_Authentication_UnkownPlayerException extends ManiaLib_Authentication_Exception {}

?>
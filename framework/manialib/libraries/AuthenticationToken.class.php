<?php
/**
 * @author Philippe Melot
 * @copyright 2009-2010 NADEO
 * @package ManiaLib
 */

/**
 * Helps using the Manialink Authentication System developped by NADEO. Note that it only works with United Forever accounts.
 */
final class AuthenticationToken
{
	const scriptUrl = 'http://scripts.trackmaniaforever.com/checkAuthenticationToken.php?login=%s&token=%s';

	/**
	 * 
	 * Check if the login and the token are correct for the
	 * authentication
	 * 
	 * @param string $playerlogin
	 * @param string $token
	 * @throws AuthenticationTokenNoLoginException
	 * @throws AuthenticationTokenInvalidTokenException
	 * @throws AuthenticationTokenInvalidLoginException
	 * @throws AuthenticationNationsTokenUnknownPlayerException
	 * @throws AuthenticationTokenBadTokenException
	 * @throws AuthenticationTokenFailedException
	 * @return bool
	 */
	static function checkAuthenticationToken($playerlogin, $token)
	{
		if(!$playerlogin)
		throw new AuthenticationTokenNoLoginException();
		if(!$token)
		throw new AuthenticationTokenInvalidTokenException();
		
		$scriptUrl = sprintf(self::scriptUrl,$playerlogin,$token);
		
		$response = file_get_contents($scriptUrl);
		
		$error = strstr('<errors>',$response);
		
		if(!$error)
			return true;
		
		$error = str_split($error, strlen( strstr('</response>',$error) ) );
		
		switch($error)
		{
			case 7: 	throw new AuthenticationTokenInvalidLoginException();
				break;
			case 14: 	throw new AuthenticationNationsTokenUnknownPlayerException();
				break;
			case 166:	throw new AuthenticationTokenInvalidTokenException();
				break;
			case 167: 	throw new AuthenticationTokenBadTokenException();
				break;
			default:	throw new AuthenticationTokenFailedException();
		}
	}
}

class AuthenticationTokenFailedException
	extends FrameworkException
{
}

class AuthenticationTokenInvalidLoginException
	extends AuthenticationTokenFailedException
{
}

class AuthenticationTokenNoLoginException
	extends AuthenticationTokenFailedException
{
}

class AuthenticationTokenBadTokenException
	extends AuthenticationTokenFailedException
{
}

class AuthenticationTokenInvalidTokenException
	extends AuthenticationTokenFailedException
{
}

class AuthenticationNationsTokenUnknownPlayerException
	extends AuthenticationTokenFailedException
{
}
?>
<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 3275 $:
 * @author      $Author: svn $:
 * @date        $Date: 2011-04-01 18:06:13 +0200 (ven., 01 avr. 2011) $:
 */

namespace ManiaLib\Authentication\Manialink;

/**
 * Manialink Authentication
 * Helps using the Manialink Authentication System developped by NADEO. 
 * Note that it only works with United Forever accounts.
 * 
 * Doc: http://scripts.trackmaniaforever.com/checkAuthenticationToken.htm
 */
abstract class Authentication extends \ManiaLib\Authentication\AbstractAuthentication
{
	const SCRIPT = 'http://scripts.trackmaniaforever.com/checkAuthenticationToken.php?login=%s&token=%s&addaccounttype=1';

	static protected function executeRequest($login, $token)
	{
		$config = \ManiaLib\Authentication\Config::getInstance();
		$url = sprintf(self::SCRIPT, $login, $token);
		if($config->userLogin && $config->userPassword)
		{
			$url .= sprintf('&userlogin=%s&userpassword=%s', $config->userLogin, $config->userPassword);
		}
		return file_get_contents($url);
	}
}

?>
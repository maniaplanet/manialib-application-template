<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2775 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-03-04 15:31:04 +0100 (ven., 04 mars 2011) $:
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
		$url = sprintf(self::SCRIPT, $login, $token);
		return file_get_contents($url);
	}
}

?>
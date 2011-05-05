<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2664 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-02-25 18:34:08 +0100 (ven., 25 févr. 2011) $:
 */

namespace ManiaLib\Authentication\Web;

abstract class Authentication extends \ManiaLib\Authentication\AbstractAuthentication
{
	const SCRIPT = 'http://%s:%s@scripts.trackmaniaforever.com/checkAuthenticationTokenForApplication.php?login=%s&token=%s&addaccounttype=1';

	static protected function executeRequest($login, $token)
	{
		$config = \ManiaLib\Authentication\Config::getInstance();
		$url = sprintf(self::SCRIPT, $config->username, $config->password, $login, $token);
		return file_get_contents($url);
	}
}

?>
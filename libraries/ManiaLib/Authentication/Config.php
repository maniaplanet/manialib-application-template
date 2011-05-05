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

class Config extends \ManiaLib\Utils\Singleton
{
	/**
	 * When using Manialink authentication, you can specify the login and password
	 * of the TMF account that created the short manialink code. It is optional,
	 * but if you use that the authentication will be more secured.
	 * @var string
	 */
	public $userLogin;
	/**
	 * @var string
	 */
	public $userPassword;


	
	/**
	 * HTTP username, you need that checking the token with WEB authentication
	 * @var string
	 */
	public $username;
	/**
	 * HTTP password, you need that checking the token with WEB authentication
	 * @var string
	 */
	public $password;
}

?>
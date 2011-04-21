<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 3513 $:
 * @author      $Author: maxime $:
 * @date        $Date: 2011-04-20 18:33:25 +0200 (mer., 20 avr. 2011) $:
 */

namespace ManiaLib\ManiaHome;

class Config extends \ManiaLib\Utils\Singleton
{
	public $manialink;
	public $username;
	public $password;
	public $name;
	public $bannerURL;
	public $buttonPosX = 39;
	public $buttonPosY = -43;
	public $buttonPosZ = 10;
}
 
?>
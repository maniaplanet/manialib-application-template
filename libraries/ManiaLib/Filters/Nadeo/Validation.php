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
 
namespace ManiaLib\Filters\Nadeo;

abstract class Validation
{
	static function login($login)
	{
		if($login && strlen($login) <= 25)
		{
			if(preg_match('/^[a-zA-Z0-9-_\.]{1,25}$/', $login))
			{
				return;
			}
		}
		throw new \InvalidArgumentException('Invalid login "'.$login.'"');
	}
	
	static function nickname($nickname)
	{
		if($nickname && strlen($nickname) <= 75)
		{
			return;
		}
		throw new \InvalidArgumentException('Invalid nickname "'.$nickname.'"');
	}
}

?>
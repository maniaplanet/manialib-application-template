<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2142 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-01-31 19:00:53 +0100 (lun., 31 janv. 2011) $:
 */

namespace ManiaLib\Utils;

abstract class Singleton
{
	protected static $instance;
	
	static function getInstance()
	{
		if(!static::$instance)
		{
			static::$instance = new static;
		}
		return static::$instance;
	}
	
	protected function __construct(){}
}


?>
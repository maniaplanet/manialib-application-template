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

namespace ManiaLib\I18n;

/**
 * I18n conf
 */
class Config extends \ManiaLib\Config\Configurable
{
	public $paths = array();
	public $dynamic = false;
	
	protected function validate()
	{
		if(defined('APP_PATH'))
		{
			if(file_exists($path = APP_PATH.'langs/'))
			{
				if(!in_array($path, $this->paths))
				{
					$this->paths[] = $path;
				}
			}
			if(file_exists($path = APP_PATH.'www/langs/'))
			{
				if(!in_array($path, $this->paths))
				{
					$this->paths[] = $path;
				}
			}
		}
	}
}


?>
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
class Config extends \ManiaLib\Utils\Singleton
{
	public $paths = array();
	public $dynamic = false;
	
	function __construct()
	{
		$this->paths[] = APP_PATH.'langs/';
		$this->paths[] = APP_PATH.'www/langs/';
	}
}

?>
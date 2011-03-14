<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2782 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-03-04 18:58:33 +0100 (ven., 04 mars 2011) $:
 */

namespace ManiaLib\Cache\Drivers;

class MemcacheConfig extends \ManiaLib\Utils\Singleton
{
	// FIXME MANIALIB CACHE We should be able to configure the hosts more precisely
	// ie. ports, weights, timeouts etc.
	public $hosts = array('127.0.0.1');
}
?>
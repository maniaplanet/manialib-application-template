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

namespace ManiaLib\Config;

/**
 * Base config
 * Extends this in your application to add config values
 * @method \ManiaLib\Config\Config getInstance()
 */
class Config extends \ManiaLib\Utils\Singleton
{

	public $debug = false;

}

?>
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

namespace ManiaLib\Benchmark;

class Config extends \ManiaLib\Config\Configurable
{
	public $enabled = false;
	/**
	 * Benchmark will be done every N requests
	 */
	public $samplingRate = 100;
	/**
	 * Stores at most N execution times in the stack 
	 */
	public $maxElements = 60;
}


?>
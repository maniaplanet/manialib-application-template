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
 */
class Config extends Configurable
{
	/**
	 * @var \ManiaLib\Application\Config
	 */
	public $application;
	/**
	 * @var \ManiaLib\Database\Config
	 */
	public $database;
	/**
	 * @var \ManiaLib\I18n\Config
	 */
	public $i18n;
	/**
	 * @var \ManiaLib\Log\Config
	 */
	public $log;
	/**
	 * @var \ManiaLib\Session\Config
	 */
	public $session;
	/**
	 * @var \ManiaLib\Benchmark\Config
	 */
	public $benchmark;
	
	public $timezone = 'Europe/Paris';
	public $timezoneName = 'GMT+1';
	
	public $debug = false;
	
	public $disableCache = false;
	
}

?>
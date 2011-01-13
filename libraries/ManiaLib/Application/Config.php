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

namespace ManiaLib\Application;

/**
 * Application config
 */
class Config extends \ManiaLib\Config\Configurable
{
	/**
	 * @var \ManiaLib\Application\Tracking\Config
	 */
	public $tracking;
	
	public $URL;
	public $manialink;
	public $namespace;
	public $name;
	
	public $langsURL;
	public $imagesURL;
	public $mediaURL;
	
	public $URLSeparator = '_';
	
	public $useRewriteRules = false;
	
	public $defaultController = 'Home';
	public $defaultAction = 'index';
	
	protected function validate()
	{
		// Check exists is not a good idea when you don't want to use it...
//		$this->checkExists('URL');
//		$this->checkExists('manialink');
//		$this->checkExists('namespace');
		$this->setDefault('langsURL', $this->URL.'langs/');
		$this->setDefault('imagesURL', $this->URL.'images/');
		$this->setDefault('mediaURL', $this->URL.'media/');
	}
}

?>
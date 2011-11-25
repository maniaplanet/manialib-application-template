<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @see         http://code.google.com/p/manialib/
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLibDemo\Controllers;

class ManiaScript extends \ManiaLib\Application\Controller
{

	protected function onConstruct()
	{
		parent::onConstruct();
		// This is to check that visitors have the latest update of Maniaplanet
		$this->addFilter(new \ManiaLib\ManiaScript\VersionCheck());
	}

	/**
	 * Maps to index.php/mania-script
	 */
	function index()
	{
		
	}

}

?>
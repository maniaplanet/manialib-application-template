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

namespace ManiaLibDemo\Controllers;

/**
 * Splash screen with "enter" button controller of our ManiaLib demo 
 */
class Splashscreen extends \ManiaLib\Application\Splashscreen\Controller 
{
	protected function onConstruct()
	{
		parent::onConstruct();
		$this->addFilter(new \ManiaLib\Application\Tracking\Filter());
		$this->addFilter(new \ManiaLibDemo\Filters\MoodSelector());
	}
}

?>
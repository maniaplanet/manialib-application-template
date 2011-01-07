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

namespace ManiaLib\Application\Views;

use ManiaLib\Gui\Manialink;
use ManiaLib\Gui\Elements\Icons64x64_1;

/**
 * Default header
 */
class Header extends \ManiaLib\Application\View
{
	function display()
	{
		Manialink::load();
		
		$ui = new Icons64x64_1(5);
		$ui->setAlign('right', 'bottom');
		$ui->setSubStyle('Refresh');
		$ui->setPosition(64, -48, 15);
		$ui->setManialink($this->request->createLink());
		$ui->save();
	}
}

?>
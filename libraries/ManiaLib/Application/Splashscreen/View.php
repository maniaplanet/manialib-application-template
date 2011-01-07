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

namespace ManiaLib\Application\Splashscreen;

/**
 * Base view for the splash screen. Override that.
 */
class View extends \ManiaLib\Application\View
{
	function display()
	{
		$ui = new Button();
		$ui->setAlign('center', 'center');
		$ui->setPosition(0, 0, 5);
		$ui->setStyle(Button::CardButtonMediumWide);
		$ui->setManialink($this->response->enterManialink);
		$ui->addPlayerId();
		$ui->setText('Enter');
		$ui->save();
	}
}

?>
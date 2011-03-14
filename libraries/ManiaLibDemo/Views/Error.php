<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 2385 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-02-16 13:03:57 +0100 (mer., 16 févr. 2011) $:
 */

namespace ManiaLibDemo\Views;

/**
 * Custom error view
 */
use ManiaLib\Gui\Elements\Button;

use ManiaLib\Gui\Elements\Label;

use ManiaLib\Gui\Manialink;

use ManiaLib\Gui\Cards\FancyPanel;

class Error extends \ManiaLib\Application\View
{
	function display()
	{
		$this->renderSubView('Header');
		
		Manialink::beginFrame(-35, 30, 1);
		{
			$ui = new FancyPanel(70, 50);
			$ui->title->setText('Oops!');
			$ui->subtitle->setText('An error has occured');
			$ui->save();
			
			$ui = new Label(66);
			$ui->setPosition(2, -14, 1);
			$ui->setStyle(Label::TextInfoSmall);
			$ui->enableAutonewline();
			$ui->setText($this->response->message);
			$ui->save();
			
			$ui = new Button();
			$ui->setHalign('center');
			$ui->setPosition(35, -44, 1);
			$ui->setManialink($this->response->backLink);
			$ui->setText('Back');
			$ui->save();
		}
		Manialink::endFrame();
		
		$this->render('\\ManiaLib\\Application\\Views\\Footer');
	}
}

?>
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

namespace ManiaLibDemo\Views\Home;

use ManiaLib\Gui\Manialink;
use ManiaLib\Gui\Cards\FancyPanel;
use ManiaLib\Gui\Elements\Button;
use ManiaLib\Gui\Elements\Label;
use ManiaLib\Gui\Elements\Icons128x128_1;
use ManiaLib\Gui\Elements\Bgs1;

class Download extends \ManiaLib\Application\View
{
	function display()
	{
		$this->renderSubView('Navigation');
		
		Manialink::beginFrame(-20, 35, 1);
		{
			$ui = new FancyPanel(70, 50);
			$ui->setSubStyle(Bgs1::BgWindow2);
			$ui->title->setText(__('download'));
			$ui->subtitle->setText(__('howto_get_manialib'));
			$ui->icon->setSubStyle(Icons128x128_1::Load);
			$ui->save();
			
			$ui = new Label(62);
			$ui->setPosition(3, -15, 1);
			$ui->enableAutonewline();
			$ui->setStyle(Label::TextValueMedium);
			$ui->setText(__('goto_project_website_explanation'));
			$ui->save();
			
			$ui = new Button();
			$ui->setHalign('center');
			$ui->setPosition(35, -30, 1);
			$ui->setScale(1.35);
			$ui->setUrl('http://code.google.com/p/manialib/');
			$ui->setText(__('goto_project_website'));
			$ui->save();
		}
		Manialink::endFrame();
	}
}

?>
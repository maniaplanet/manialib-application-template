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

use ManiaLib\Application\Route;
use ManiaLib\Gui\Manialink;
use ManiaLib\Gui\Elements\Bgs1;
use ManiaLib\Gui\Elements\Quad;
use ManiaLib\Gui\Elements\Label;
use ManiaLib\Gui\Elements\Icons128x128_1;
use ManiaLib\Gui\Cards\FancyPanel;

class About extends \ManiaLib\Application\View
{
	function display()
	{
		$this->renderSubView('Navigation');
		
		Manialink::beginFrame(-20, 35, 1);
		{
			$ui = new FancyPanel(70, 50);
			$ui->setSubStyle(Bgs1::BgWindow2);
			$ui->title->setText(__('about'));
			$ui->subtitle->setText(__('what_is_manialib'));
			$ui->icon->setSubStyle(Icons128x128_1::Custom);
			$ui->save();
			
			Manialink::beginFrame(0, -15, 1);
			{
				$ui = new Label(60);
				$ui->setHalign('center');
				$ui->setPosition(35, 0, 0);
				$ui->enableAutonewline();
				$ui->setTextColor('ff0');
				$ui->setTextSize(4);
				$ui->setText('$o$i'.__('manialib_helps_php_programmers').'$z');
				$ui->save();
				
				$ui = new Label(62);
				$ui->setPosition(3, -12, 0);
				$ui->enableAutonewline();
				$ui->setStyle(Label::TextValueMedium);
				$ui->setText(__('manialib_explanation'));
				$ui->save();
			}
			Manialink::endFrame();
		}
		Manialink::endFrame();
	}
}

?>
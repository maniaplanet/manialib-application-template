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

use ManiaLib\Gui\Elements\Label;
use ManiaLib\Gui\Elements\Quad;
use ManiaLib\Gui\Elements\Icons128x128_1;
use ManiaLib\Gui\Elements\Bgs1;
use ManiaLib\Gui\Cards\FancyPanel;
use ManiaLib\Gui\Manialink;

class Showcase extends \ManiaLib\Application\View
{
	function display()
	{
		$this->renderSubView('Navigation');
		
		Manialink::beginFrame(-20, 35, 1);
		{
			$ui = new FancyPanel(70, 50);
			$ui->setSubStyle(Bgs1::BgWindow2);
			$ui->title->setText(__('showcase'));
			$ui->subtitle->setText(__('whos_using_manialib'));
			$ui->icon->setSubStyle(Icons128x128_1::ServersSuggested);
			$ui->save();
			
			$ui = new Quad(60, 20);
			$ui->setPosition(5, -15, 0);
			$ui->setSubStyle(Bgs1::BgList);
			$ui->save();
			
			$ui = new Label(29);
			$ui->setPosition(7, -17, 1);
			$ui->enableAutonewline();
			$ui->setText(
				'$o'.
				'$hManialink:Home$h'."\n".
				'$hManiaPub$h'."\n".
				'$hManiaHome$h'."\n".
				'$hManiaSpace$h'."\n".
				'$hManiaTeam$h'."\n".
				'$hManiaHost$h'."\n");
			$ui->save();
		}
		Manialink::endFrame();
		
	}
}

?>
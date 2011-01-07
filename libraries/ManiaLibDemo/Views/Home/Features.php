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

use ManiaLib\Gui\Cards\FancyPanel;
use ManiaLib\Gui\Manialink;
use ManiaLib\Gui\Elements\Icons128x128_1;
use ManiaLib\Gui\Layouts\Column;
use ManiaLib\Gui\Elements\Bgs1;

class Features extends \ManiaLib\Application\View
{
	function display()
	{
		$this->renderSubView('Navigation');
		
		Manialink::beginFrame(-20, 35, 1);
		{
			$ui = new FancyPanel(70, 73);
			$ui->setSubStyle(Bgs1::BgWindow2);
			$ui->title->setText(__('features'));
			$ui->subtitle->setText(__('whats_in_manialib'));
			$ui->icon->setSubStyle(Icons128x128_1::Forever);
			$ui->save();
			
			Manialink::beginFrame(4, -15, 1, null, new Column());
			{
				for($i=1; $i<=7; $i++)
				{
					$ui = new \ManiaLib\Gui\Cards\Bullet(62);
					$ui->bullet->setSubStyle(Icons128x128_1::Advanced);
					$ui->title->setText(__('features_bullet'.$i));
					$ui->save();
				}
			}
			Manialink::endFrame();
		}
		Manialink::endFrame();
	}
}

?>
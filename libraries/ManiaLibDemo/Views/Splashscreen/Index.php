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

namespace ManiaLibDemo\Views\Splashscreen;

use ManiaLib\Gui\Manialink;
use ManiaLib\Gui\Elements\Bgs1;
use ManiaLib\Gui\Elements\Quad;
use ManiaLib\Gui\Elements\Label;
use ManiaLib\Application\Route;

class Index extends \ManiaLib\Application\View
{
	function display()
	{
		Manialink::beginFrame(0, 35, 1);
		{
			$manialink = $this->request->createLink(Route::CUR, 'enter');
			
			$ui = new Bgs1(150, 57);
			$ui->setHalign('center');
			$ui->setSubStyle(Bgs1::BgCard3);
			$ui->setManialink($manialink);
			$ui->addPlayerId();
			$ui->save();
			
			$ui = new Label(60);
			$ui->setPosition(0, -10, 1);
			$ui->setHalign('center');
			$ui->setTextSize(9);
			$ui->setTextColor('fff');
			$ui->setText('$oManiaLib');
			$ui->save();
			
			$ui = new Label(60);
			$ui->setPosition(0, -17, 1);
			$ui->setHalign('center');
			$ui->setTextSize(2);
			$ui->setTextColor('ff0');
			$ui->setText('$oLightweight PHP framework for Manialinks');
			$ui->save();
			
			$ui = new Quad(30, 30);
			$ui->setPosition(0, -20, 0);
			$ui->setHalign('center');
			$ui->setImage('logo.dds');
			$ui->save();
		}
		Manialink::endFrame();
	}
}

?>
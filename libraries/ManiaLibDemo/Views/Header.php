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

namespace ManiaLibDemo\Views;

use ManiaLib\Gui\Manialink;
use ManiaLib\Gui\Elements\Quad;
use ManiaLib\Gui\Elements\Label;
use ManiaLib\Gui\Elements\Icons128x128_1;


/**
 */
class Header extends \ManiaLib\Application\Views\Header
{
	function display()
	{
		parent::display();
		
		// Background
		$ui = new Quad(128, 96);
		$ui->setAlign('center', 'center');
		$ui->setImage($this->response->backgroundImage);
		$ui->save();
		
		// Watermark. Would be nice to leave it :)
		$ui = new Label(20, 0);
		$ui->setAlign('center', 'bottom');
		$ui->setPosition(0, -48, 15);
		$ui->setScale(0.75);
		$ui->setStyle(Label::TextCardSmallScores2Rank);
		$ui->setText(__('powered_by_manialib'));
		$ui->setManialink('manialib');
		$ui->save();
		
		// Mood selector
		$this->request->set('show_mood_selector', true);
		$manialink = $this->request->createLink();
		$this->request->delete('show_mood_selector');
		
		$ui = new Icons128x128_1(5);
		$ui->setAlign('right', 'bottom');
		$ui->setSubStyle(Icons128x128_1::Paint);
		$ui->setPosition(39, -48, 15);
		$ui->setManialink($manialink);
		$ui->save();

		// TODO Do something better for ManiaHome
		Manialink::beginFrame(39, -43, 15);
		{
			Manialink::appendXML(
				'<include url="http://maniahome.trackmania.com/add.php?'.
				'name='.\ManiaLib\Application\Config::getInstance()->name.
				'&amp;url='.\ManiaLib\Application\Config::getInstance()->manialink.
				'"/>');
		}
		Manialink::endFrame();	
	}
}


?>
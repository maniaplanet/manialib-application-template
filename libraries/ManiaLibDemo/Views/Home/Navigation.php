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

/**
 */
class Navigation extends \ManiaLib\Application\View
{
	function display()
	{
		$ui = new \ManiaLib\Gui\Cards\Navigation\Menu();
		$ui->logo->setImage('logo64.dds');
		$ui->title->setText(__('ManiaLib'));
		$ui->subTitle->setText(__('empower_your_manialinks'));
		
		$manialink = $this->request->createLink(Route::CUR, Route::NONE);
		$selected = $this->request->isAction('About', 'About');
		
		$ui->addItem();
		$ui->lastItem->setManialink($manialink);
		if($selected) $ui->lastItem->setSelected();
		$ui->lastItem->icon->setSubStyle(Icons128x128_1::Manialink);
		$ui->lastItem->text->setText(__('about'));
		
		$manialink = $this->request->createLink(Route::CUR, 'Features');
		$selected = $this->request->isAction('Features');
		
		$ui->addItem();
		$ui->lastItem->setManialink($manialink);
		if($selected) $ui->lastItem->setSelected();
		$ui->lastItem->icon->setSubStyle(Icons128x128_1::Forever);
		$ui->lastItem->text->setText(__('features'));
		
		$manialink = $this->request->createLink(Route::CUR, 'Download');
		$selected = $this->request->isAction('Download');
		
		$ui->addItem();
		$ui->lastItem->setManialink($manialink);
		if($selected) $ui->lastItem->setSelected();
		$ui->lastItem->icon->setSubStyle(Icons128x128_1::Load);
		$ui->lastItem->text->setText(__('download'));
		
		$manialink = $this->request->createLink(Route::CUR, 'Showcase');
		$selected = $this->request->isAction('Showcase');
		
		$ui->addItem();
		$ui->lastItem->setManialink($manialink);
		if($selected) $ui->lastItem->setSelected();
		$ui->lastItem->icon->setSubStyle(Icons128x128_1::ServersSuggested);
		$ui->lastItem->text->setText(__('showcase'));
		
		$manialink = $this->request->createLink('Examples', Route::NONE);
		
		$ui->addItem();
		$ui->lastItem->setManialink($manialink);
		$ui->lastItem->icon->setSubStyle(Icons128x128_1::Browse);
		$ui->lastItem->text->setText(__('sample_pages'));
		
		$manialink = $this->request->createLink('Shoutbox', Route::NONE);
		
		$ui->addItem();
		$ui->lastItem->setManialink($manialink);
		$ui->lastItem->icon->setSubStyle(Icons128x128_1::Share);
		$ui->lastItem->text->setText(__('shoutbox'));
		
		$ui->quitButton->setManialink('Manialink:home');
		$ui->save();
	}
}


?>
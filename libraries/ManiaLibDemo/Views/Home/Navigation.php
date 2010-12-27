<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 */
class ManiaLibDemo_Views_Home_Navigation extends ManiaLib_Application_View
{
	function display()
	{
		$ui = new ManiaLib_Gui_Cards_Navigation_Menu();
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
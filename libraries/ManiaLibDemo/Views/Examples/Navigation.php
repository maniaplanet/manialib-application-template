<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 */
class ManiaLibDemo_Views_Examples_Navigation extends ManiaLib_Application_View
{
	function display()
	{
		$ui = new ManiaLib_Gui_Cards_Navigation_Menu();
		$ui->logo->setSubStyle(Icons128x128_1::Browse);
		$ui->title->setText(__('sample_pages'));
		$ui->subTitle->setText(__('a_few_examples'));
		
		$manialink = $this->request->createLink(Route::CUR, Route::NONE);
		$selected = $this->request->isAction('Layouts', 'Layouts');
		
		$ui->addItem();
		$ui->lastItem->setManialink($manialink);
		if($selected) $ui->lastItem->setSelected();
		$ui->lastItem->icon->setSubStyle(Icons128x128_1::Editor);
		$ui->lastItem->text->setText(__('layouts'));
		
		$manialink = $this->request->createLink(Route::CUR, 'tracks');
		$selected = $this->request->isAction('Tracks');
		
		$ui->addItem();
		$ui->lastItem->setManialink($manialink);
		if($selected) $ui->lastItem->setSelected();
		$ui->lastItem->icon->setSubStyle(Icons128x128_1::Editor);
		$ui->lastItem->text->setText(__('tracks'));
		
		$manialink = $this->request->createLink(Route::DEF, Route::NONE);
		
		$ui->quitButton->setManialink($manialink);
		$ui->save();
	}
}


?>
<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 */
class ManiaLibDemo_Views_Shoutbox_Navigation extends ManiaLib_Application_View
{
	function display()
	{
		$ui = new ManiaLib_Gui_Cards_Navigation_Menu();
		$ui->logo->setSubStyle(Icons128x128_1::Share);
		$ui->title->setText(__('shoutbox'));
		$ui->subTitle->setText(__('shoutbox_example'));
		
		$manialink = $this->request->createLink(Route::CUR, Route::NONE);
		$selected = $this->request->getAction('viewShouts') == 'viewShouts';
		
		$ui->addItem();
		$ui->lastItem->setManialink($manialink);
		if($selected) $ui->lastItem->setSelected();
		$ui->lastItem->icon->setSubStyle(Icons128x128_1::Share);
		$ui->lastItem->text->setText(__('view_shouts'));
		
		$manialink = $this->request->createLink(Route::DEF, Route::NONE);
		
		$ui->quitButton->setManialink($manialink);
		$ui->save();
	}
}


?>
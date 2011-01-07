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

namespace ManiaLibDemo\Views\Shoutbox;

use ManiaLib\Application\Route;
use ManiaLib\Gui\Elements\Icons128x128_1;
use ManiaLib\Gui\Cards\Navigation\Menu;

class Navigation extends \ManiaLib\Application\View
{
	function display()
	{
		$ui = new Menu();
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
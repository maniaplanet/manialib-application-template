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

namespace ManiaLibDemo\Views\Examples;

use ManiaLib\Application\Route;
use ManiaLib\Gui\Elements\Icons128x128_1;
use ManiaLib\Gui\Cards\Navigation\Menu;

class Navigation extends \ManiaLib\Application\View
{
	function display()
	{
		$ui = new Menu();
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
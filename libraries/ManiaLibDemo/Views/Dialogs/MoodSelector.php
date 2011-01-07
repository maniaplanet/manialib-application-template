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

namespace ManiaLibDemo\Views\Dialogs;

use ManiaLib\Gui\Elements\Icons128x128_1;
use ManiaLib\Gui\Elements\Quad;
use ManiaLib\Gui\Manialink;
use ManiaLib\Application\Route;

class MoodSelector extends \ManiaLib\Application\Views\Dialogs\OneButton
{
	function onConstruct()
	{
		$this->response->dialog->buttonLabel = 'Cancel';
		$this->response->dialog->title = __('select_mood');
		$this->response->dialog->buttonManialink = $this->request->createLink(Route::CUR, Route::CUR);
	}
	
	function display()
	{
		parent::display();
		
		Manialink::beginFrame(-20, 4, 16, null, new \ManiaLib\Gui\Layouts\Line());
		{
			$this->request->set('select_mood', 'mp');
			$manialink = $this->request->createLink(Route::CUR, Route::CUR); 
			
			$ui = new Quad(10, 10);
			$ui->setStyle(Quad::Icons128x128_1);
			$ui->setSubStyle(Icons128x128_1::Extreme);
			$ui->setManialink($manialink);
			$ui->save();
			
			$this->request->set('select_mood', 'tm');
			$manialink = $this->request->createLink(Route::CUR, Route::CUR); 
			
			$ui = new Quad(10, 10);
			$ui->setStyle(Quad::Icons128x128_1);
			$ui->setSubStyle(Icons128x128_1::Easy);
			$ui->setManialink($manialink);
			$ui->save();
			
			$this->request->set('select_mood', 'sm');
			$manialink = $this->request->createLink(Route::CUR, Route::CUR); 
			
			$ui = new Quad(10, 10);
			$ui->setStyle(Quad::Icons128x128_1);
			$ui->setSubStyle(Icons128x128_1::Hard);
			$ui->setManialink($manialink);
			$ui->save();
			
			$this->request->set('select_mood', 'qm');
			$manialink = $this->request->createLink(Route::CUR, Route::CUR); 
			
			$ui = new Quad(10, 10);
			$ui->setStyle(Quad::Icons128x128_1);
			$ui->setSubStyle(Icons128x128_1::Medium);
			$ui->setManialink($manialink);
			$ui->save();
			
			$this->request->delete('select_mood');
		}
		Manialink::endFrame();
	}
}

?>
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

use ManiaLib\Gui\Cards\Challenge;
use ManiaLib\Application\Route;
use ManiaLib\Gui\Manialink;
use ManiaLib\Gui\Layouts\Flow;

class Tracks extends \ManiaLib\Application\View
{
	function display()
	{
		$this->renderSubView('Navigation');
		
		// We create a FlowLayout to place elements in a grid
		$layout = new Flow(80, 80);
		$layout->setMargin(2,2);
		
		// Then we apply this layout to a new Frame.
		Manialink::beginFrame(-20, 40, 1, null, $layout);
		{
			// We loop to create 16 "dummy" ChallengeCard
			for($i=0; $i < 16; $i++)
			{
				$manialink = $this->request->createLink(Route::CUR, Route::CUR);
				
				$ui = new Challenge();
				$ui->bgImage->setStyle(null);
				$ui->bgImage->setBgcolor('ccc');
				$ui->text->setText('My track');
				$ui->setManialink($manialink);
				$ui->save();
			}
		}
		Manialink::endFrame();
	}
}

?>
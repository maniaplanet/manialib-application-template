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

use ManiaLib\Gui\Layouts\Line;
use ManiaLib\Gui\Elements\Quad;
use ManiaLib\Gui\Layouts\Column;
use ManiaLib\Gui\Cards\Panel;
use ManiaLib\Gui\Layouts\Spacer;
use ManiaLib\Gui\Manialink;
use ManiaLib\Gui\Layouts\Flow;

class Layouts extends \ManiaLib\Application\View
{
	function display()
	{
		$this->renderSubView('Navigation');
		
		$layout = new Flow(70, 70);
		$layout->setMargin(3, 3);
		
		Manialink::beginFrame(-18, 35, 1, null, $layout);
		{
			$layout = new Spacer(30, 30);
			Manialink::beginFrame(0, 0, 1, null, $layout);
			{
				////////////////////////////////////////////////////////////////////////
				// \ManiaLib\Gui\Layouts\Column example
				////////////////////////////////////////////////////////////////////////
				
				$ui = new Panel(30, 30);
				$ui->title->setText('\ManiaLib\Gui\Layouts\Column');
				$ui->save();
				
				$layout = new Column(30, 30);
				$layout->setMarginHeight(1);
				$layout->setBorder(1, 6);
				
				Manialink::beginFrame(0, 0, 1, null, $layout);
				{
					$ui = new Quad(5, 5);
					$ui->save();
				
					$ui = new Quad(5, 5);
					$ui->save();
				
					$ui = new Quad(5, 5);
					$ui->save();
				}
				Manialink::endFrame();
			}
			Manialink::endFrame();
			
			$layout = new Spacer(30, 30);
			Manialink::beginFrame(0, 0, 1, null, $layout);
			{
				////////////////////////////////////////////////////////////////////////
				// \ManiaLib\Gui\Layouts\Line example
				////////////////////////////////////////////////////////////////////////
				
				$ui = new Panel(30, 30);
				$ui->title->setText('\ManiaLib\Gui\Layouts\Line');
				$ui->save();
				
				$layout = new Line(30, 30);
				$layout->setMarginWidth(1);
				$layout->setBorder(1, 6);
				
				Manialink::beginFrame(0, 0, 1, null, $layout);
				{
					$ui = new Quad(5, 5);
					$ui->save();
				
					$ui = new Quad(5, 5);
					$ui->save();
				
					$ui = new Quad(5, 5);
					$ui->save();
				}
				Manialink::endFrame();
			}
			Manialink::endFrame();
		
			$layout = new \ManiaLib\Gui\Layouts\Spacer(30, 30);
			Manialink::beginFrame(0, 0, 1, null, $layout);
			{
				////////////////////////////////////////////////////////////////////////
				// \ManiaLib\Gui\Layouts\Flow example
				////////////////////////////////////////////////////////////////////////
				
				$ui = new Panel(30, 30);
				$ui->title->setText('\ManiaLib\Gui\Layouts\Flow');
				$ui->save();
				
				$layout = new Flow(30, 30);
				$layout->setMargin(1, 1);
				$layout->setBorder(1, 6);
				
				Manialink::beginFrame(0, 0, 1, null, $layout);
				{
					$ui = new Quad(5, 5);
					$ui->save();
				
					$ui = new Quad(5, 5);
					$ui->save();
				
					$ui = new Quad(5, 5);
					$ui->save();
					
					$ui = new Quad(5, 5);
					$ui->save();
				
					$ui = new Quad(5, 5);
					$ui->save();
				
					$ui = new Quad(5, 5);
					$ui->save();
					
					$ui = new Quad(5, 5);
					$ui->save();
					
					$ui = new Quad(5, 5);
					$ui->save();
					
					$ui = new Quad(5, 5);
					$ui->save();
				}
				Manialink::endFrame();
			}
			Manialink::endFrame();
		
			$layout = new Spacer(30, 30);
			Manialink::beginFrame(0, 0, 1, null, $layout);
			{
				////////////////////////////////////////////////////////////////////////
				// \ManiaLib\Gui\Layouts\Flow example 2
				////////////////////////////////////////////////////////////////////////
				
				$ui = new Panel(30, 30);
				$ui->title->setText('\ManiaLib\Gui\Layouts\Flow');
				$ui->save();
				
				$layout = new \ManiaLib\Gui\Layouts\Flow(30, 30);
				$layout->setMargin(1, 1);
				$layout->setBorder(1, 6);
				
				Manialink::beginFrame(0, 0, 1, null, $layout);
				{
					$ui = new Quad(5, 1);
					$ui->save();
				
					$ui = new Quad(5, 2);
					$ui->save();
				
					$ui = new Quad(5, 3);
					$ui->save();
					
					$ui = new Quad(5, 4);
					$ui->save();
				
					$ui = new Quad(5, 5);
					$ui->save();
				
					$ui = new Quad(1, 5);
					$ui->save();
					
					$ui = new Quad(2, 5);
					$ui->save();
					
					$ui = new Quad(3, 5);
					$ui->save();
					
					$ui = new Quad(4, 5);
					$ui->save();
					
					$ui = new Quad(5, 5);
					$ui->save();
					
					$ui = new Quad(35, 5);
					$ui->save();$ui = new Quad(35, 5);
					$ui->save();
				}
				Manialink::endFrame();
			}
			Manialink::endFrame();
		}
		Manialink::endFrame();
	}
}

?>
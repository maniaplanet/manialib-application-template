<?php

class ManiaLibDemo_Views_Examples_Layouts extends ManiaLib_Application_View
{
	function display()
	{
		$this->renderSubView('Navigation');
		
		$layout = new ManiaLib_Gui_Layouts_Flow(70, 70);
		$layout->setMargin(3, 3);
		
		Manialink::beginFrame(-18, 35, 1, null, $layout);
		{
			$layout = new ManiaLib_Gui_Layouts_Spacer(30, 30);
			Manialink::beginFrame(0, 0, 1, null, $layout);
			{
				////////////////////////////////////////////////////////////////////////
				// ManiaLib_Gui_Layouts_Column example
				////////////////////////////////////////////////////////////////////////
				
				$ui = new Panel(30, 30);
				$ui->title->setText('ManiaLib_Gui_Layouts_Column');
				$ui->save();
				
				$layout = new ManiaLib_Gui_Layouts_Column(30, 30);
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
			
			$layout = new ManiaLib_Gui_Layouts_Spacer(30, 30);
			Manialink::beginFrame(0, 0, 1, null, $layout);
			{
				////////////////////////////////////////////////////////////////////////
				// ManiaLib_Gui_Layouts_Line example
				////////////////////////////////////////////////////////////////////////
				
				$ui = new Panel(30, 30);
				$ui->title->setText('ManiaLib_Gui_Layouts_Line');
				$ui->save();
				
				$layout = new ManiaLib_Gui_Layouts_Line(30, 30);
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
		
			$layout = new ManiaLib_Gui_Layouts_Spacer(30, 30);
			Manialink::beginFrame(0, 0, 1, null, $layout);
			{
				////////////////////////////////////////////////////////////////////////
				// ManiaLib_Gui_Layouts_Flow example
				////////////////////////////////////////////////////////////////////////
				
				$ui = new Panel(30, 30);
				$ui->title->setText('ManiaLib_Gui_Layouts_Flow');
				$ui->save();
				
				$layout = new ManiaLib_Gui_Layouts_Flow(30, 30);
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
		
			$layout = new ManiaLib_Gui_Layouts_Spacer(30, 30);
			Manialink::beginFrame(0, 0, 1, null, $layout);
			{
				////////////////////////////////////////////////////////////////////////
				// ManiaLib_Gui_Layouts_Flow example 2
				////////////////////////////////////////////////////////////////////////
				
				$ui = new Panel(30, 30);
				$ui->title->setText('ManiaLib_Gui_Layouts_Flow');
				$ui->save();
				
				$layout = new ManiaLib_Gui_Layouts_Flow(30, 30);
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
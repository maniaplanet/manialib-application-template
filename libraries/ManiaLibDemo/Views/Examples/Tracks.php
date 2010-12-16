<?php

class ManiaLibDemo_Views_Examples_Tracks extends ManiaLib_Application_View
{
	function display()
	{
		$this->renderSubView('Navigation');
		
		// We create a FlowLayout to place elements in a grid
		$layout = new ManiaLib_Gui_Layouts_Flow(80, 80);
		$layout->setMargin(2,2);
		
		// Then we apply this layout to a new Frame.
		Manialink::beginFrame(-20, 40, 1, null, $layout);
		{
			// We loop to create 16 "dummy" ChallengeCard
			for($i=0; $i < 16; $i++)
			{
				$manialink = $this->request->createLink(Route::CUR, Route::CUR);
				
				$ui = new ManiaLib_Gui_Cards_Challenge();
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
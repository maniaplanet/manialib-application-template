<?php

class ManiaLib_Application_Views_Dialogs_OneButton 
	extends ManiaLib_Application_View
	implements ManiaLib_Application_Views_Dialogs_DialogInterface
{
	function display()
	{
		$ui = new Quad(200, 200);
		$ui->setAlign('center', 'center');
		$ui->setPosition(0, 0, 14);
		$ui->setSubStyle(Bgs1::BgWindow2);
		$ui->save();
		
		Manialink::beginFrame(
			$this->response->dialog->posX, 
			$this->response->dialog->posY, 
			$this->response->dialog->posZ);
		{
			$ui = new ManiaLib_Gui_Cards_Dialogs_OneButton(
				$this->response->dialog->width, $this->response->dialog->height);
			$ui->setAlign('center','center');
			$ui->title->setText($this->response->dialog->title);
			$ui->button->setText($this->response->dialog->buttonLabel);
			$ui->button->setManialink($this->response->dialog->buttonManialink);
			$ui->save();	
		}
		Manialink::endFrame();
	}	
}


?>
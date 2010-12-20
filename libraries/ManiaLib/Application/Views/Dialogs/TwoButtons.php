<?php

class ManiaLib_Application_Views_Dialogs_TwoButtons 
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
		
		Manialink::beginFrame(0, 0, 15);
		{
			$ui = new ManiaLib_Gui_Cards_Dialogs_TwoButtons(
				$this->response->dialog->width, $this->response->dialog->height);
			$ui->setAlign('center','center');
			$ui->title->setText($this->response->dialog->title);
			$ui->button->setText($this->response->dialog->buttonLabel);
			$ui->button->setManialink($this->response->dialog->buttonManialink);
			$ui->button2->setText($this->response->dialog->button2Label);
			$ui->button2->setManialink($this->response->dialog->button2Manialink);
			$ui->save();	
		}
		Manialink::endFrame();
	}
}

?>
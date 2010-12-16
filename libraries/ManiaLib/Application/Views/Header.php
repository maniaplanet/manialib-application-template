<?php 

class ManiaLib_Application_Views_Header extends ManiaLib_Application_View
{
	function display()
	{
		ManiaLib_Gui_Manialink::load();
		
		$ui = new Icons64x64_1(5);
		$ui->setAlign('right', 'bottom');
		$ui->setSubStyle('Refresh');
		$ui->setPosition(64, -48, 15);
		$ui->setManialink($this->request->createLink());
		$ui->save();
	}
}

?>
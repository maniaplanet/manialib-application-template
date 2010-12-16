<?php

class ManiaLibDemo_Views_Dialogs_MoodSelector extends ManiaLib_Application_Views_Dialogs_OneButton
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
		
		Manialink::beginFrame(-20, 4, 16, null, new ManiaLib_Gui_Layouts_Line());
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
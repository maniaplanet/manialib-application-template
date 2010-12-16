<?php

class ManiaLibDemo_Views_Home_Showcase extends ManiaLib_Application_View
{
	function display()
	{
		$this->renderSubView('Navigation');
		
		Manialink::beginFrame(-20, 35, 1);
		{
			$ui = new FancyPanel(70, 50);
			$ui->setSubStyle(Bgs1::BgWindow2);
			$ui->title->setText(__('showcase'));
			$ui->subtitle->setText(__('whos_using_manialib'));
			$ui->icon->setSubStyle(Icons128x128_1::ServersSuggested);
			$ui->save();
			
			$ui = new Quad(60, 20);
			$ui->setPosition(5, -15, 0);
			$ui->setSubStyle(Bgs1::BgList);
			$ui->save();
			
			$ui = new Label(29);
			$ui->setPosition(7, -17, 1);
			$ui->enableAutonewline();
			$ui->setText(
				'$o'.
				'$hManialink:Home$h'."\n".
				'$hManiaPub$h'."\n".
				'$hManiaHome$h'."\n".
				'$hManiaSpace$h'."\n".
				'$hManiaTeam$h'."\n".
				'$hManiaHost$h'."\n");
			$ui->save();
		}
		Manialink::endFrame();
		
	}
}

?>
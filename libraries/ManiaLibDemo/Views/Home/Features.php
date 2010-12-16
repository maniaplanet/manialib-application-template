<?php

class ManiaLibDemo_Views_Home_Features extends ManiaLib_Application_View
{
	function display()
	{
		$this->renderSubView('Navigation');
		
		Manialink::beginFrame(-20, 35, 1);
		{
			$ui = new FancyPanel(70, 73);
			$ui->setSubStyle(Bgs1::BgWindow2);
			$ui->title->setText(__('features'));
			$ui->subtitle->setText(__('whats_in_manialib'));
			$ui->icon->setSubStyle(Icons128x128_1::Forever);
			$ui->save();
			
			Manialink::beginFrame(4, -15, 1, null, new ManiaLib_Gui_Layouts_Column());
			{
				for($i=1; $i<=7; $i++)
				{
					$ui = new ManiaLib_Gui_Cards_Bullet(62);
					$ui->bullet->setSubStyle(Icons128x128_1::Advanced);
					$ui->title->setText(__('features_bullet'.$i));
					$ui->save();
				}
			}
			Manialink::endFrame();
		}
		Manialink::endFrame();
	}
}

?>
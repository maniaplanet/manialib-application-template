<?php

class ManiaLibDemo_Views_Shoutbox_ViewShouts extends ManiaLib_Application_View
{
	function display()
	{
		$this->renderSubView('Navigation');
		
		Manialink::beginFrame(-15, 35, 1);
		{
			$ui = new FancyPanel(60, 60);
			$ui->setSubStyle(Bgs1::BgWindow2);
			$ui->title->setText(__('shoutbox'));
			$ui->subtitle->setText(__('shoutbox_example'));
			$ui->icon->setSubStyle(Icons128x128_1::Share);
			$ui->save();
			
			Manialink::beginFrame(2, -15, 0, null, new ManiaLib_Gui_Layouts_Column());
			{
				foreach((array)$this->response->shouts as $shout)
				{
					Manialink::beginFrame(0, 0, 0, null, new ManiaLib_Gui_Layouts_Spacer(55, 3.25));
					{
						$ui = new BgsPlayerCard(15, 3);
						$ui->setPosition(0, 0, 0);
						$ui->setSubStyle(BgsPlayerCard::BgPlayerName);
						$ui->save();
						
						$ui = new Label(13);
						$ui->setPosition(1, -0.25, 0);
						$ui->setText($shout->nickname);
						$ui->save();
						
						$ui = new BgsPlayerCard(40, 3);
						$ui->setPosition(15, 0, 0);
						$ui->setSubStyle(BgsPlayerCard::BgPlayerCardSmall);
						$ui->save();
						
						$ui = new Label(38);
						$ui->setPosition(16, -0.25, 0);
						$ui->setText($shout->message);
						$ui->save();
					}
					Manialink::endFrame();
				}
			}
			Manialink::endFrame();
			
			Manialink::beginFrame(2, -52, 1);
			{
				$this->request->set('message', 'message');
				$manialink = $this->request->createLink(Route::CUR, 'postShout');
				$this->request->restore('message');
				
				$ui = new Button();
				$ui->setPosition(0, 0, 0);
				$ui->setScale(0.575);
				$ui->addPlayerId();
				$ui->setManialink($manialink);
				$ui->setText('$w'.__('SHOUT'));
				$ui->save();
				
				$ui = new Entry(40, 3);
				$ui->setPosition(15, 0, 0);
				$ui->setName('message');
				$ui->setDefault('');
				$ui->save();
			}
			Manialink::endFrame();
		}
		Manialink::endFrame();
	}
}

?>
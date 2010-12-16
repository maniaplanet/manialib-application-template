<?php

class ManiaLibDemo_Views_Splash_Index extends ManiaLib_Application_View
{
	function display()
	{
		Manialink::beginFrame(0, 35, 1);
		{
			$manialink = $this->request->createLink(Route::CUR, 'enter');
			
			$ui = new Bgs1(150, 57);
			$ui->setHalign('center');
			$ui->setSubStyle(Bgs1::BgCard3);
			$ui->setManialink($manialink);
			$ui->addPlayerId();
			$ui->save();
			
			$ui = new Label(60);
			$ui->setPosition(0, -10, 1);
			$ui->setHalign('center');
			$ui->setTextSize(9);
			$ui->setTextColor('fff');
			$ui->setText('$oManiaLib');
			$ui->save();
			
			$ui = new Label(60);
			$ui->setPosition(0, -17, 1);
			$ui->setHalign('center');
			$ui->setTextSize(2);
			$ui->setTextColor('ff0');
			$ui->setText('$oLightweight PHP framework for Manialinks');
			$ui->save();
			
			$ui = new Quad(30, 30);
			$ui->setPosition(0, -20, 0);
			$ui->setHalign('center');
			$ui->setImage('logo.dds');
			$ui->save();
		}
		Manialink::endFrame();
	}
}

?>
<?php 

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

Manialink::beginFrame(-60, 48, 1);
{
	Manialink::beginFrame(0, 0, 0);
	{
		$ui = new Quad(35, 25);
		$ui->setPosition(0, 5);
		$ui->setSubStyle(Bgs1::NavButtonBlink);
		$ui->save();
		
		Manialink::beginFrame(2, -8, 1);
		{
			$ui = new Quad(9, 9);
			$ui->setImage('logo64.dds');
			$ui->save();
			
			$ui = new Label(50);
			$ui->setPosition(9, -1.75, 0);
			$ui->setStyle(Label::TextRankingsBig);
			$ui->setText('ManiaLib');
			$ui->save();
			
			$ui = new Label(50);
			$ui->setPosition(9, -5.25, 0);
			$ui->setStyle(Label::TextInfoSmall);
			$ui->setText('Empower your Manialinks!');
			$ui->save();
		}
		Manialink::endFrame();
	}
	Manialink::endFrame();
	
	Manialink::beginFrame(0, -21, 0);
	{
		$layout = new ColumnLayout();
		$layout->setMarginHeight(1);
		
		Manialink::beginFrame(0, 0, 0, $layout);
		{
			$manialink = $request->createLink(null, 'about');
			
			$ui = new NavigationButton(35, 8);
			$ui->setManialink($manialink);
			$ui->icon->setSubStyle(Icons128x128_1::Manialink);
			$ui->text->setText('About');
			$ui->save();
			
			$manialink = $request->createLink(null, 'features');
			
			$ui = new NavigationButton(35, 8);
			$ui->setManialink($manialink);
			$ui->icon->setSubStyle(Icons128x128_1::Forever);
			$ui->text->setText('Features');
			$ui->save();
			
			$manialink = $request->createLink(null, 'download');
			
			$ui = new NavigationButton(35, 8);
			$ui->setManialink($manialink);
			$ui->icon->setSubStyle(Icons128x128_1::Load);
			$ui->text->setText('Download');
			$ui->save();
			
			$manialink = $request->createLink(null, 'showcase');
			
			$ui = new NavigationButton(35, 8);
			$ui->setManialink($manialink);
			$ui->icon->setSubStyle(Icons128x128_1::ServersSuggested);
			$ui->text->setText('Showcase');
			$ui->save();
			
			$manialink = $request->createLink('examples', 'index');
			
			$ui = new NavigationButton(35, 8);
			$ui->setManialink($manialink);
			$ui->icon->setSubStyle(Icons128x128_1::Browse);
			$ui->text->setText('Sample pages');
			$ui->save();
			
			$ui = new Quad(35, 45);
			$ui->setSubStyle(Bgs1::NavButtonBlink);
			$ui->save();
		}
		Manialink::endFrame();
	}
	Manialink::endFrame();
}
Manialink::endFrame();

?>
<?php 
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

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
			$ui->setStyle(Quad::Icons128x128_1);
			$ui->setSubStyle(Icons128x128_1::Share);
			$ui->save();
			
			$ui = new Label(50);
			$ui->setPosition(9, -1.75, 0);
			$ui->setStyle(Label::TextRankingsBig);
			$ui->setText('Shoutbox');
			$ui->save();
			
			$ui = new Label(50);
			$ui->setPosition(9, -5.25, 0);
			$ui->setStyle(Label::TextInfoSmall);
			$ui->setText('Shoutbox example');
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
			$manialink = $request->createLink(Route::CUR, Route::NONE);
			$selected = $request->getAction('view_shouts') == 'view_shouts';
			
			$ui = new NavigationButton(35, 8);
			if($selected) $ui->setSelected();
			$ui->setManialink($manialink);
			$ui->icon->setSubStyle(Icons128x128_1::Share);
			$ui->text->setText('View shouts');
			$ui->save();
			
			$manialink = $request->createLink(Route::DEF, Route::NONE);
			
			$ui = new NavigationButton(35, 8);
			$ui->setManialink($manialink);
			$ui->icon->setSubStyle(Icons128x128_1::Back);
			$ui->text->setText('Back');
			$ui->save();
			
			$ui = new Quad(35, 70);
			$ui->setSubStyle(Bgs1::NavButtonBlink);
			$ui->save();
		}
		Manialink::endFrame();
	}
	Manialink::endFrame();
}
Manialink::endFrame();

?>
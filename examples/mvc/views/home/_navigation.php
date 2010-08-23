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
			$ui->setImage('logo64.dds');
			$ui->save();
			
			$ui = new Label(50);
			$ui->setPosition(9, -1.75, 0);
			$ui->setStyle(Label::TextRankingsBig);
			$ui->setText(__('ManiaLib'));
			$ui->save();
			
			$ui = new Label(50);
			$ui->setPosition(9, -5.25, 0);
			$ui->setStyle(Label::TextInfoSmall);
			$ui->setText(__('empower_your_manialinks'));
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
			$selected = $request->getAction('about') == 'about';
			
			$ui = new NavigationButton(35, 8);
			if($selected) $ui->setSelected();
			$ui->setManialink($manialink);
			$ui->icon->setSubStyle(Icons128x128_1::Manialink);
			$ui->text->setText(__('about'));
			$ui->save();
			
			$manialink = $request->createLink(Route::CUR, 'features');
			$selected = $request->getAction() == 'features';
			
			$ui = new NavigationButton(35, 8);
			if($selected) $ui->setSelected();
			$ui->setManialink($manialink);
			$ui->icon->setSubStyle(Icons128x128_1::Forever);
			$ui->text->setText(__('features'));
			$ui->save();
			
			$manialink = $request->createLink(Route::CUR, 'download');
			$selected = $request->getAction() == 'download';
			
			$ui = new NavigationButton(35, 8);
			if($selected) $ui->setSelected();
			$ui->setManialink($manialink);
			$ui->icon->setSubStyle(Icons128x128_1::Load);
			$ui->text->setText(__('download'));
			$ui->save();
			
			$manialink = $request->createLink(Route::CUR, 'showcase');
			$selected = $request->getAction() == 'showcase';
			
			$ui = new NavigationButton(35, 8);
			if($selected) $ui->setSelected();
			$ui->setManialink($manialink);
			$ui->icon->setSubStyle(Icons128x128_1::ServersSuggested);
			$ui->text->setText(__('showcase'));
			$ui->save();
			
			$manialink = $request->createLink('examples', Route::NONE);
			
			$ui = new NavigationButton(35, 8);
			$ui->setManialink($manialink);
			$ui->icon->setSubStyle(Icons128x128_1::Browse);
			$ui->text->setText(__('sample_pages'));
			$ui->save();
			
			$manialink = $request->createLink('shoutbox', Route::NONE);
			
			$ui = new NavigationButton(35, 8);
			$ui->setManialink($manialink);
			$ui->icon->setSubStyle(Icons128x128_1::Share);
			$ui->text->setText(__('shoutbox'));
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
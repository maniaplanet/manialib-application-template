<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */
 
$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

View::render('shoutbox', '_navigation');


Manialink::beginFrame(-12, 35, 1);
{
	$ui = new Quad(60, 60);
	$ui->setSubStyle(Bgs1::BgWindow2);
	$ui->save();
	
	Manialink::beginFrame(2, -3, 1);
	{
		$ui = new Quad(8, 8);
		$ui->setStyle(Quad::Icons128x128_1);
		$ui->setSubStyle(Icons128x128_1::Share);
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -0.5, 0);
		$ui->setStyle(Label::TextRankingsBig);
		$ui->setText(__('shoutbox'));
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -4, 0);
		$ui->setStyle(Label::TextInfoSmall);
		$ui->setText(__('shoutbox_example'));
		$ui->save();
	}
	Manialink::endFrame();
	
	Manialink::beginFrame(2, -15, 0, new ColumnLayout());
	{
		foreach((array)$response->shouts as $shout)
		{
			Manialink::beginFrame(0, 0, 0, new NullLayout(55, 3.25));
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
		$request->set('message', 'message');
		$manialink = $request->createLink(Route::CUR, 'post_shout');
		$request->restore('message');
		
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

?>
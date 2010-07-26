<?php 
/**
 * @author Maxime Raoust
 * @copyright NADEO
 */

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

View::render('home', 'navigation');

////////////////////////////////////////////////////////////////////////////////
// "Features" panel
////////////////////////////////////////////////////////////////////////////////
Manialink::beginFrame(-15, 35, 1);
{
	$ui = new Quad(70, 50);
	$ui->setSubStyle(Bgs1::BgWindow2);
	$ui->save();
	
	Manialink::beginFrame(2, -3, 1);
	{
		$ui = new Quad(8, 8);
		$ui->setStyle(Quad::Icons128x128_1);
		$ui->setSubStyle(Icons128x128_1::Forever);
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -0.5, 0);
		$ui->setStyle(Label::TextRankingsBig);
		$ui->setText('Features');
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -4, 0);
		$ui->setStyle(Label::TextInfoSmall);
		$ui->setText('What\'s in ManiaLib?');
		$ui->save();
	}
	Manialink::endFrame();
}
Manialink::endFrame();

?>
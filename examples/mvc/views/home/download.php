<?php 
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

View::render('home', '_navigation');

////////////////////////////////////////////////////////////////////////////////
// "Download" panel
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
		$ui->setSubStyle(Icons128x128_1::Load);
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -0.5, 0);
		$ui->setStyle(Label::TextRankingsBig);
		$ui->setText('Download');
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -4, 0);
		$ui->setStyle(Label::TextInfoSmall);
		$ui->setText('How to get ManiaLib?');
		$ui->save();
	}
	Manialink::endFrame();
	
	$ui = new Label(62);
	$ui->setPosition(3, -15, 1);
	$ui->enableAutonewline();
	$ui->setStyle(Label::TextValueMedium);
	$ui->setText(
		'Visit the project\'s page on Google Code to download the latest '.
		'version of ManiaLib. You will also find examples and documentation.');
	$ui->save();
	
	$ui = new Button;
	$ui->setHalign('center');
	$ui->setPosition(35, -30, 1);
	$ui->setScale(1.35);
	$ui->setUrl('http://code.google.com/p/manialib/');
	$ui->setText('Go to the project\'s website');
	$ui->save();
}
Manialink::endFrame();

?>
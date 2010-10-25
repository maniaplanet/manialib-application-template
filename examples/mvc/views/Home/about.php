<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

View::render('Home', '_navigation');

////////////////////////////////////////////////////////////////////////////////
// "About" panel
////////////////////////////////////////////////////////////////////////////////
Manialink::beginFrame(-20, 35, 1);
{
	$ui = new Quad(70, 50);
	$ui->setSubStyle(Bgs1::BgWindow2);
	$ui->save();
	
	Manialink::beginFrame(2, -3, 1);
	{
		$ui = new Quad(8, 8);
		$ui->setStyle(Quad::Icons128x128_1);
		$ui->setSubStyle(Icons128x128_1::Custom);
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -0.5, 0);
		$ui->setStyle(Label::TextRankingsBig);
		$ui->setText(__('about'));
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -4, 0);
		$ui->setStyle(Label::TextInfoSmall);
		$ui->setText(__('what_is_manialib'));
		$ui->save();
	}
	Manialink::endFrame();
	
	Manialink::beginFrame(0, -15, 1);
	{
		$ui = new Label(60);
		$ui->setHalign('center');
		$ui->setPosition(35, 0, 0);
		$ui->enableAutonewline();
		$ui->setTextColor('ff0');
		$ui->setTextSize(4);
		$ui->setText('$o$i'.__('manialib_helps_php_programmers').'$z');
		$ui->save();
		
		$ui = new Label(62);
		$ui->setPosition(3, -12, 0);
		$ui->enableAutonewline();
		$ui->setStyle(Label::TextValueMedium);
		$ui->setText(__('manialib_explanation'));
		$ui->save();
	}
	Manialink::endFrame();
}
Manialink::endFrame();
?>
<?php

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

View::render('home', 'navigation');

////////////////////////////////////////////////////////////////////////////////
// "About" panel
////////////////////////////////////////////////////////////////////////////////
Manialink::beginFrame(-15, 35, 1);
{
	$ui = new Quad(70, 50);
	$ui->setSubStyle(Bgs1::BgWindow2);
	$ui->save();
	
	Manialink::beginFrame(2, -3, 1);
	{
		$ui = new Quad(8, 8);
		$ui->setImage('logo64.dds');
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -0.5, 0);
		$ui->setStyle(Label::TextRankingsBig);
		$ui->setText('About');
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -4, 0);
		$ui->setStyle(Label::TextInfoSmall);
		$ui->setText('What is ManiaLib?');
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
		$ui->setText(
			'$o$iManiaLib helps PHP programmers create dynamic Manialinks faster$z');
		$ui->save();
		
		$ui = new Label(62);
		$ui->setPosition(3, -12, 0);
		$ui->enableAutonewline();
		$ui->setStyle(Label::TextValueMedium);
		$ui->setText(
			'In more technical terms, ManiaLib is a $olightweight '.
			'PHP framework$o for the development of Manialinks. '.
			'It provides a set of object-oriented libraries to help  '.
			'you save time on classic ManiaLink tasks.');
		$ui->save();
	}
	Manialink::endFrame();
}
Manialink::endFrame();
?>
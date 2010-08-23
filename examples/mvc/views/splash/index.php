<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

Manialink::beginFrame(0, 20, 1);
{
	$manialink = $request->createLink(Route::CUR, 'enter');
	
	$ui = new Bgs1(50, 10);
	$ui->setHalign('center');
	$ui->setSubStyle(Bgs1::NavButton);
	$ui->addPlayerId();
	$ui->setManialink($manialink);
	$ui->save();
	
	$ui = new Label;
	$ui->setHalign('center');
	$ui->setPosition(0, -3, 1);
	$ui->setScale(1.25);
	$ui->setStyle(Label::TextRankingsBig);
	$ui->setText('Enter');
	$ui->save();
}
Manialink::endFrame();


?>
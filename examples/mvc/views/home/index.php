<?php 

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

Manialink::beginFrame(0, 0, 1);
{
	$ui = new Panel(50, 30);
	$ui->setAlign('center', 'center');
	$ui->title->setText('ManiaLib');
	$ui->save();
	
	$ui = new Label(40);
	$ui->setAlign('center', 'center');
	$ui->setPosition(0, 0, 1);
	$ui->setStyle(Label::TextRankingsBig);
	$ui->setText('Hello world');
	$ui->save();
}
Manialink::endFrame();

?>
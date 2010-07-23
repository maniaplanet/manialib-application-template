<?php 
/**
 * 
 * @author Maxime Raoust
 * @copyright Nadeo
 */

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

////////////////////////////////////////////////////////////////////////////////
// Dialog
////////////////////////////////////////////////////////////////////////////////
$ui = new Quad(200, 200);
$ui->setAlign('center', 'center');
$ui->setPosition(0, 0, 14);
$ui->setSubStyle(Bgs1::BgWindow2);
$ui->save();

Manialink::beginFrame(0, 0, 15);
{
	$ui = new TwoButtonsDialogCard;
	$ui->setAlign('center','center');
	$ui->title->setText($response->dialogTitle);
	$ui->button->setText($response->dialogButtonLabel);
	$ui->button->setManialink($response->dialogButtonManialink);
	$ui->button2->setText($response->dialogButton2Label);
	$ui->button2->setManialink($response->dialogButton2Manialink);
	$ui->save();	
}
Manialink::endFrame();

?>
<?php 
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 * @package ManiaLib
 * @subpackage MVC
 * @ignore
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
	$ui = new DialogCard($response->dialog->width, $response->dialog->height);
	$ui->setAlign('center','center');
	$ui->title->setText($response->dialog->title);
	$ui->button->setText($response->dialog->buttonLabel);
	$ui->button->setManialink($response->dialog->buttonManialink);
	$ui->save();	
}
Manialink::endFrame();

?>
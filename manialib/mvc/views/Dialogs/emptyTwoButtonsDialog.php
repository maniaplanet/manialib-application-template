<?php 
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 * @package ManiaLib_MVC
 */

/**#@+
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
	$ui = new TwoButtonsDialogCard($response->dialog->width, $response->dialog->height);
	$ui->setAlign('center','center');
	$ui->title->setText($response->dialog->title);
	$ui->button->setText($response->dialog->buttonLabel);
	$ui->button->setManialink($response->dialog->buttonManialink);
	$ui->button2->setText($response->dialog->button2Label);
	$ui->button2->setManialink($response->dialog->button2Manialink);
	$ui->save();	
}
Manialink::endFrame();
/**#@-*/

?>
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
$manialink = $request->createLink(null, 'index'); 
View::render('dialogs', 'empty_dialog');

////////////////////////////////////////////////////////////////////////////////
// Content
////////////////////////////////////////////////////////////////////////////////
Manialink::beginFrame(0, 0, 16);
{
	$ui = new Label(60);
	$ui->setAlign('center', 'center');
	$ui->enableAutonewline();
	$ui->setPosition(0, 2, 1);
	$ui->setText($response->dialogMessage);
	$ui->save();
}
Manialink::endFrame();

?>
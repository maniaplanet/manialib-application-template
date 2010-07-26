<?php 
/**
 * @author Maxime Raoust
 * @copyright NADEO
 */

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

////////////////////////////////////////////////////////////////////////////////
// Dialog
////////////////////////////////////////////////////////////////////////////////
$response->dialogButtonLabel = 'Cancel';
View::render('dialogs', 'empty_dialog');

Manialink::beginFrame(-20, 4, 16, new LineLayout());
{
	$request->set('select_mood', 'mp');
	$manialink = $request->createLink(Route::CUR, Route::CUR); 
	
	$ui = new Quad(10, 10);
	$ui->setStyle(Quad::Icons128x128_1);
	$ui->setSubStyle(Icons128x128_1::Extreme);
	$ui->setManialink($manialink);
	$ui->save();
	
	$request->set('select_mood', 'tm');
	$manialink = $request->createLink(Route::CUR, Route::CUR); 
	
	$ui = new Quad(10, 10);
	$ui->setStyle(Quad::Icons128x128_1);
	$ui->setSubStyle(Icons128x128_1::Easy);
	$ui->setManialink($manialink);
	$ui->save();
	
	$request->set('select_mood', 'sm');
	$manialink = $request->createLink(Route::CUR, Route::CUR); 
	
	$ui = new Quad(10, 10);
	$ui->setStyle(Quad::Icons128x128_1);
	$ui->setSubStyle(Icons128x128_1::Hard);
	$ui->setManialink($manialink);
	$ui->save();
	
	$request->set('select_mood', 'qm');
	$manialink = $request->createLink(Route::CUR, Route::CUR); 
	
	$ui = new Quad(10, 10);
	$ui->setStyle(Quad::Icons128x128_1);
	$ui->setSubStyle(Icons128x128_1::Medium);
	$ui->setManialink($manialink);
	$ui->save();
	
	$request->delete('select_mood');
}
Manialink::endFrame();

?>
<?php 

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

// Loads the GUI toolkit
Manialink::load();

// Background
$ui = new Quad(128, 96);
$ui->setAlign('center', 'center');
$ui->setImage('qm-clouds.jpg');
$ui->save();

// Mood selector
$request->set('show_mood_selector', true);
$manialink = $request->createLink();
$request->restore('show_mood_selector');

$ui = new Icon(5);
$ui->setAlign('right', 'bottom');
$ui->setSubStyle(Icons128x128_1::Paint);
$ui->setPosition(39, -48, 15);
$ui->setManialink($manialink);
$ui->save();

// Maniahome
Manialink::beginFrame(39, -43, 15);
{
	Manialink::appendXML(
		'<include url="http://maniahome.trackmania.com/add.php?name='.
		APP_MANIALINK.
		'&amp;url='.
		APP_MANIALINK.
	//	'&amp;picture='.
	//	'[pictureUrl]'.
		'"/>');
}
Manialink::endFrame();

// Refresh button
$ui = new Icon64(5);
$ui->setAlign('right', 'bottom');
$ui->setSubStyle(Icons64x64_1::Refresh);
$ui->setPosition(64, -48, 15);
$ui->setManialink($request->createLink());
$ui->save();

?>
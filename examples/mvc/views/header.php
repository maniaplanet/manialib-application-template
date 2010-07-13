<?php 

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

// Loads the GUI toolkit
Manialink::load();

// Background
$ui = new Quad(128, 128);
$ui->setAlign('center', 'center');
$ui->setImage('bg_stadium.dds');
$ui->save();

// Refresh button
$ui = new Icon64(5);
$ui->setAlign('right', 'bottom');
$ui->setSubStyle('Refresh');
$ui->setPosition(64, -48, 15);
$ui->setManialink($request->createLink());
$ui->save();

?>
<?php
/**
 * @author Maxime Raoust
 */

$request = RequestEngine::GetInstance();

Manialink::load();

LangEngine::getInstance();

$ui = new Quad(128, 128);
$ui->setAlign('center', 'center');
$ui->setImage('bg_stadium.dds');
$ui->save();

$ui = new Icon64(4);
$ui->setAlign('right', 'bottom');
$ui->setSubStyle('Refresh');
$ui->setPosition(64, -48, 15);
$ui->setManialink($request->createLink());
$ui->save();

$ui = new Label;
$ui->setAlign("center", "bottom");
$ui->setPosition(15, -48, 1);
$ui->setTextSize(1);
$ui->setText('Powered by $<$ccc$o$h[manialib]Manialib$h$>');
$ui->save();

?>
<?php
/**
 * @author Maxime Raoust
 */

$request = RequestEngine::getInstance();

$ui = new Navigation;
$ui->title->setText('ManiaLib');
$ui->subTitle->setText('Lightweight PHP framework');
$ui->logo->setImage('logo64.dds');

$manialink = $request->createLinkArgList('index.php');
$ui->addItem();
$ui->lastItem()->text->setText('Home');
$ui->lastItem()->icon->setSubStyle(Icons128x128_1::United);
$ui->lastItem()->setManialink($manialink);

$manialink = $request->createLinkArgList('example1.php');
$ui->addItem();
$ui->lastItem()->text->setText('Example page 1');
$ui->lastItem()->icon->setSubStyle(Icons128x128_1::Challenge);
$ui->lastItem()->setManialink($manialink);

$manialink = $request->createLinkArgList('layouts.php');
$ui->addItem();
$ui->lastItem()->text->setText('Layouts example');
$ui->lastItem()->icon->setSubStyle(Icons128x128_1::Advanced);
$ui->lastItem()->setManialink($manialink);
	
$ui->quitButton->setManialink('Manialink:home');
$ui->quitButton->text->setText('Quit');

$ui->save();

?>
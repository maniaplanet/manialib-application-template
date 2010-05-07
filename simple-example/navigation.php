<?php
/**
 * @author Maxime Raoust
 */

$request = RequestEngine::getInstance();

$ui = new Navigation;
$ui->title->setText('Manialib');
$ui->subTitle->setText('Lightweight PHP framework');
$ui->logo->setImage('logo64.dds');
{
	$link = $request->createLinkArgList('index.php');
	$ui->addItem();
	$ui->lastItem()->text->setText('Home');
	$ui->lastItem()->icon->setSubStyle('United');
	$ui->lastItem()->setManialink($link);
	
	$link = $request->createLinkArgList('layouts.php');
	$ui->addItem();
	$ui->lastItem()->text->setText('Layouts demo');
	$ui->lastItem()->icon->setSubStyle('Advanced');
	$ui->lastItem()->setManialink($link);
		
	$ui->quitButton->setManialink('Manialink:home');
	$ui->quitButton->text->setText('Quit');
}
$ui->save();

?>
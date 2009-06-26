<?php
/**
 * Navigation menu
 * @author Maxime Raoust
 */

$request = RequestEngine::getInstance();

$ui = new Navigation;
$ui->title->setText("ManiaLib");
$ui->subTitle->setText("Lightweight framework");
$ui->logo->setSubStyle("Forever");

$link = $request->createLinkArgList("index.php");

$ui->addItem();
$ui->lastItem()->text->setText("Home");
$ui->lastItem()->icon->setSubStyle("United");
$ui->lastItem()->setManialink($link);

$ui->addGap(56);

$link = $request->createLinkArgList("admin/index.php");

$ui->addItem();
$ui->lastItem()->text->setText("Admin");
$ui->lastItem()->icon->setSubStyle("ProfileAdvanced");
$ui->lastItem()->setManialink($link);


$ui->quitButton->setManialink($request->createLinkArgList("index.php"));
$ui->draw();

?>
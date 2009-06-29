<?php
/**
 * Navigation menu
 * @author Maxime Raoust
 */

$request = RequestEngine::getInstance();

$ui = new Navigation;
$ui->title->setText("ManiaLib");
$ui->subTitle->setText("Lightweight PHP framework");
$ui->logo->setImage("logo64.dds");

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

$linkstr = $request->createLinkArgList("index.php");
$ui->quitButton->setManialink($linkstr);

$ui->draw();

?>
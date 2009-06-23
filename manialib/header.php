<?php
/**
 * Header
 * @author Maxime Raoust
 */

$link = LinkEngine::GetInstance();

$ui = new Manialink;
$ui->draw();

$ui = new Quad(128, 128);
$ui->setAlign("center", "center");
$ui->setImage("bg_stadium.dds");
$ui->draw();

$ui = new Navigation;
$ui->title->setText("ManiaLib");
$ui->subTitle->setText("Simple manialink framework");
$ui->logo->setSubStyle("Forever");

$linkstr = $link->createLinkArgList("index.php");

$ui->addItem();
$ui->lastItem()->text->setText("Home");
$ui->lastItem()->icon->setSubStyle("United");
$ui->lastItem()->setManialink($linkstr);

$linkstr = $link->createLinkArgList("page.php");

$ui->addItem();
$ui->lastItem()->text->setText("Page");
$ui->lastItem()->icon->setSubStyle("Advanced");
$ui->lastItem()->setManialink($linkstr);

$ui->quitButton->setManialink("Manialink:Home");
$ui->draw();






?>
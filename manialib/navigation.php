<?php
/**
 * Navigation menu
 * @author Maxime Raoust
 */

$link = LinkEngine::getInstance();

$ui = new Navigation;
$ui->title->setText("ManiaLib");
$ui->subTitle->setText("Lightweight framework");
$ui->logo->setSubStyle("Forever");

$linkstr = $link->createLinkArgList("index.php");

$ui->addItem();
$ui->lastItem()->text->setText("Home");
$ui->lastItem()->icon->setSubStyle("United");
$ui->lastItem()->setManialink($linkstr);

$ui->addGap(56);

$linkstr = $link->createLinkArgList("admin/index.php");

$ui->addItem();
$ui->lastItem()->text->setText("Admin");
$ui->lastItem()->icon->setSubStyle("ProfileAdvanced");
$ui->lastItem()->setManialink($linkstr);


$ui->quitButton->setManialink($link->createLinkArgList("index.php"));
$ui->draw();

?>
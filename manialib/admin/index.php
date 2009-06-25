<?php
/**
 * Admin index
 * @author Maxime Raoust
 */
 
require_once( dirname(__FILE__) . "/../core.inc.php" );

// Put this line at the begining of every admin script
AdminEngine::checkAuthentication();

$link = LinkEngine::getInstance();

require_once( APP_PATH . "header.php" );

$ui = new Navigation;
$ui->title->setText("Admin");
$ui->subTitle->setText("Manage your Manialink");
$ui->logo->setSubStyle("ProfileAdvanced");

$linkstr = $link->createLinkArgList("posts.php");

$ui->addItem();
$ui->lastItem()->text->setText("Posts");
$ui->lastItem()->icon->setSubStyle("Paint");
$ui->lastItem()->setManialink($linkstr);

$ui->addGap(56);

$linkstr = $link->createLinkArgList("logout.php");

$ui->addItem();
$ui->lastItem()->text->setText("Logout");
$ui->lastItem()->icon->setStyle("Icons64x64_1");
$ui->lastItem()->icon->setSubStyle("QuitRace");
$ui->lastItem()->setManialink($linkstr);

$ui->quitButton->setManialink($link->createLinkArgList("../index.php"));
$ui->draw();

require_once( APP_PATH . "footer.php" );

?>
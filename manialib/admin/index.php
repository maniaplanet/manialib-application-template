<?php
/**
 * Admin index
 * @author Maxime Raoust
 */
 
require_once( dirname(__FILE__) . "/../core.inc.php" );

// Put this line at the begining of every admin script
AdminEngine::checkAuthentication();

$request = RequestEngine::getInstance();

require_once( APP_PATH . "header.php" );

$ui = new Navigation;
$ui->title->setText("Admin");
$ui->subTitle->setText("Manage your Manialink");
$ui->logo->setSubStyle("ProfileAdvanced");

$link = $request->createLinkArgList("posts.php");

$ui->addItem();
$ui->lastItem()->text->setText("Posts");
$ui->lastItem()->icon->setSubStyle("Paint");
$ui->lastItem()->setManialink($link);

$link = $request->createLinkArgList("admins.php");

$ui->addItem();
$ui->lastItem()->text->setText("Admins");
$ui->lastItem()->icon->setSubStyle("Profile");
$ui->lastItem()->setManialink($link);

$ui->addGap(47);

$link = $request->createLinkArgList("logout.php");

$ui->addItem();
$ui->lastItem()->text->setText("Logout");
$ui->lastItem()->icon->setStyle("Icons64x64_1");
$ui->lastItem()->icon->setSubStyle("QuitRace");
$ui->lastItem()->setManialink($link);

$ui->quitButton->setManialink($request->createLinkArgList("../index.php"));
$ui->draw();

require_once( APP_PATH . "footer.php" );

?>
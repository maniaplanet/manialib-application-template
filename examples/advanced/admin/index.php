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
$ui->title->setText(__("admin"));
$ui->subTitle->setText(__("manage_your_manialink"));
$ui->logo->setSubStyle("ProfileAdvanced");

$link = $request->createLinkArgList("posts.php");

$ui->addItem();
$ui->lastItem()->text->setText(__("posts"));
$ui->lastItem()->icon->setSubStyle("Paint");
$ui->lastItem()->setManialink($link);

$link = $request->createLinkArgList("admin.php");

$ui->addItem();
$ui->lastItem()->text->setText(__("admins"));
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
$ui->save();

require_once( APP_PATH . "footer.php" );

?>
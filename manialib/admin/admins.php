<?php
/**
 * Admin management
 * @author Maxime Raoust
 * @package admin
 */
 
require_once( dirname(__FILE__) . "/../core.inc.php" );

AdminEngine::checkAuthentication();

require_once( APP_PATH . "header.php" );

$ui = new Navigation;
$ui->title->setText("Admins");
$ui->subTitle->setText("Manage admins");
$ui->logo->setSubStyle("Profile");

$linkstr = $link->createLinkArgList("admins_admin.php");

$ui->addItem();
$ui->lastItem()->text->setText("Add an admin");
$ui->lastItem()->icon->setSubStyle("Solo");
$ui->lastItem()->setManialink($linkstr);

$linkstr = $link->createLinkArgList("admins_admin.php");

$ui->addItem();
$ui->lastItem()->text->setText("Change your password");
$ui->lastItem()->icon->setSubStyle("Options");
$ui->lastItem()->setManialink($linkstr);

$ui->quitButton->setManialink($link->createLinkArgList("index.php"));
$ui->draw();

require_once( APP_PATH . "footer.php" );



?>
<?php
/**
 * Admin manage posts
 * @author Maxime Raoust
 * @package posts
 */

require_once( dirname(__FILE__) . "/../core.inc.php" );

AdminEngine::checkAuthentication();

require_once( APP_PATH . "header.php" );

$ui = new Navigation;
$ui->title->setText("Manage posts");
$ui->subTitle->setText("Modify posts");
$ui->logo->setSubStyle("Paint");

$ui->quitButton->setManialink($link->createLinkArgList("posts.php"));
$ui->draw();

require_once( APP_PATH . "footer.php" );

?>
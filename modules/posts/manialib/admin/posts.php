<?php
/**
 * Posts management
 * @author Maxime Raoust
 * @package posts
 */

require_once( dirname(__FILE__) . "/../core.inc.php" );

AdminEngine::checkAuthentication();

require_once( APP_PATH . "header.php" );

$ui = new Navigation;
$ui->title->setText("Posts");
$ui->subTitle->setText("Manage your posts");
$ui->logo->setSubStyle("Paint");

$link = $request->createLinkArgList("posts_post.php");

$ui->addItem();
$ui->lastItem()->text->setText("Add post");
$ui->lastItem()->icon->setSubStyle("Paint");
$ui->lastItem()->setManialink($link);

$link = $request->createLinkArgList("posts_manage.php");

$ui->addItem();
$ui->lastItem()->text->setText("Manage posts");
$ui->lastItem()->icon->setSubStyle("Paint");
$ui->lastItem()->setManialink($link);

$ui->quitButton->setManialink($request->createLinkArgList("index.php"));
$ui->draw();

require_once( APP_PATH . "footer.php" );

?>
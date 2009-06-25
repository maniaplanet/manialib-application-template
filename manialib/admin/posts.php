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

$linkstr = $link->createLinkArgList("posts_post.php");

$ui->addItem();
$ui->lastItem()->text->setText("Add post");
$ui->lastItem()->icon->setSubStyle("Paint");
$ui->lastItem()->setManialink($linkstr);

$linkstr = $link->createLinkArgList("posts_manage.php");

$ui->addItem();
$ui->lastItem()->text->setText("Manage posts");
$ui->lastItem()->icon->setSubStyle("Paint");
$ui->lastItem()->setManialink($linkstr);

$ui->quitButton->setManialink($link->createLinkArgList("index.php"));
$ui->draw();

require_once( APP_PATH . "footer.php" );

?>
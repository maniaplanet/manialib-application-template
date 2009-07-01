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
$ui->title->setText(__("posts"));
$ui->subTitle->setText(__("manage_posts"));
$ui->logo->setSubStyle("Paint");

$link = $request->createLinkArgList("posts_post.php");

$ui->addItem();
$ui->lastItem()->text->setText(__("add_post"));
$ui->lastItem()->icon->setSubStyle("Paint");
$ui->lastItem()->setManialink($link);

$link = $request->createLinkArgList("posts_manage.php");

$ui->addItem();
$ui->lastItem()->text->setText(__("manage_posts"));
$ui->lastItem()->icon->setSubStyle("Paint");
$ui->lastItem()->setManialink($link);

$ui->quitButton->setManialink($request->createLinkArgList("index.php"));
$ui->save();

require_once( APP_PATH . "footer.php" );

?>
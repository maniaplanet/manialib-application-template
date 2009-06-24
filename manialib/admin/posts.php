<?php
/**
 * Posts management
 * @author Maxime Raoust
 * @package posts
 */

require_once( dirname(__FILE__) . "/../core.inc.php" );

require_once( APP_PATH . "header.php" );

$ui = new Navigation;
$ui->title->setText("Posts");
$ui->subTitle->setText("Manage your posts");
$ui->logo->setSubStyle("Paint");

$linkstr = $link->createLinkArgList("admin/posts_new_post.php");

$ui->addItem();
$ui->lastItem()->text->setText("Add post");
$ui->lastItem()->icon->setSubStyle("Paint");
$ui->lastItem()->setManialink($linkstr);

$ui->quitButton->setManialink($link->createLinkArgList("admin/index.php"));
$ui->draw();

require_once( APP_PATH . "footer.php" );

?>
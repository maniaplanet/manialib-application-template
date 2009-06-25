<?php
/**
 * Admin login
 * @author Maxime Raoust
 * @package admin
 */

require_once( dirname(__FILE__) . "/../core.inc.php" );
$link = LinkEngine::getInstance();

if(AdminEngine::authenticate())
{
	$link->redirectManialink("admin/index.php");
}

require_once( APP_PATH . "header.php" );

$ui = new Navigation;
$ui->title->setText("Admin");
$ui->subTitle->setText("Manage your Manialink");
$ui->logo->setSubStyle("ProfileAdvanced");

$ui->quitButton->setManialink($link->createLinkArgList("index.php"));
$ui->draw();

Manialink::beginFrame(15, 0, 2);

	$ui = new Panel(50, 50);
	$ui->setAlign("center", "center");
	$ui->title->setText("Login");
	$ui->draw();
	
	$ui = new Label;
	$ui->setHalign("center");
	$ui->setPosition(0, 10, 1);
	$ui->setText("Enter your password");
	$ui->draw();
	
	$ui = new Entry(40);
	$ui->setHalign("center");
	$ui->setPosition(0, 5, 1);
	$ui->setName("password");
	$ui->draw();
	
	$link->setParam("password", "password");
	
	$linkstr = $link->createLink("admin/login.php");
	
	$ui = new Button;
	$ui->setHalign("center");
	$ui->setPosition(0, -10, 1);
	$ui->setText("Sign in");
	$ui->addPlayerId();
	$ui->setManialink($linkstr);
	$ui->draw();
	
	

Manialink::endFrame();

require_once( APP_PATH . "footer.php" );

?>
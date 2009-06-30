<?php
/**
 * Admin login
 * @author Maxime Raoust
 * @package admin
 */

require_once( dirname(__FILE__) . "/../core.inc.php" );
$request = RequestEngine::getInstance();

if(AdminEngine::authenticate())
{
	$request->redirectManialink("index.php");
}

require_once( APP_PATH . "header.php" );

$ui = new Navigation;
$ui->title->setText("Admin");
$ui->subTitle->setText("Manage your Manialink");
$ui->logo->setSubStyle("ProfileAdvanced");

$ui->quitButton->setManialink($request->createLinkArgList("../index.php"));
$ui->save();

Manialink::beginFrame(15, 0, 2);

	$ui = new Panel(50, 50);
	$ui->setAlign("center", "center");
	$ui->title->setText("Login");
	$ui->save();
	
	$ui = new Label;
	$ui->setHalign("center");
	$ui->setPosition(0, 10, 1);
	$ui->setText("Enter your password");
	$ui->save();
	
	$ui = new Entry(40);
	$ui->setHalign("center");
	$ui->setPosition(0, 5, 1);
	$ui->setName("password");
	$ui->save();
	
	$request->set("password", "password");
	
	$link = $request->createLink("login.php");
	
	$ui = new Button;
	$ui->setHalign("center");
	$ui->setPosition(0, -10, 1);
	$ui->setText("Sign in");
	$ui->addPlayerId();
	$ui->setManialink($link);
	$ui->save();
	
	

Manialink::endFrame();

require_once( APP_PATH . "footer.php" );

?>
<?php
/**
 * Header
 * @author Maxime Raoust
 */

$request = RequestEngine::GetInstance();

Manialink::load();

$ui = new Quad(128, 128);
$ui->setAlign("center", "center");
$ui->setImage("bg_stadium.dds");
$ui->save();

$ui = new Label;
$ui->setAlign("center", "bottom");
$ui->setPosition(15, -48, 1);
$ui->setTextSize(1);
$ui->setText('Powered by $<$ccc$o$h[manialib]ManiaLib$h$>');
$ui->save();

$ui = new Icon64;
$ui->setAlign("right", "bottom");
$ui->setSubStyle("Refresh");
$ui->setPosition(64, -48, 15);
$ui->setManialink($request->createLink());
$ui->save();

// Debug button to reload the page while hooking to the XDEBUG listenner
// Useful is you use XDEBUG to debug your application
if(DEBUG_LEVEL >= DEBUG_ON)
{
	$request->set("XDEBUG_SESSION_START", "testID");
	$link = $request->createLink();
	$request->delete("XDEBUG_SESSION_START");
	
	$ui = new Icon64;
	$ui->setAlign("right", "bottom");
	$ui->setPosition(57, -48, 15);
	$ui->setSubStyle("ToolRoot");
	$ui->setManialink($link);
	$ui->save();
}





?>
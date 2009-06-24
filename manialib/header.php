<?php
/**
 * Header
 * @author Maxime Raoust
 */

$link = LinkEngine::GetInstance();

$ui = new Manialink;
$ui->draw();

$ui = new Quad(128, 128);
$ui->setAlign("center", "center");
$ui->setImage("bg_stadium.dds");
$ui->draw();

$ui = new Label;
$ui->setAlign("center", "bottom");
$ui->setPosition(15, -48, 1);
$ui->setTextSize(1);
$ui->setText('Powered by $<$ccc$o$h[manialib]ManiaLib$h$>');
$ui->draw();

$ui = new Icon64;
$ui->setAlign("right", "bottom");
$ui->setSubStyle("Refresh");
$ui->setPosition(64, -48, 15);
$ui->setManialink($link->createLink());
$ui->draw();


$link->setParam("XDEBUG_SESSION_START", "testID");
$linkstr = $link->createLink();
$link->deleteParam("XDEBUG_SESSION_START");

$ui = new Icon64;
$ui->setAlign("right", "bottom");
$ui->setPosition(57, -48, 15);
$ui->setSubStyle("ToolRoot");
$ui->setManialink($linkstr);
$ui->draw();




?>
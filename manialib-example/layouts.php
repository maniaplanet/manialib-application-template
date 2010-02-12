<?php

/*
 * Created on 11 févr. 2010
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */

require_once ("core.inc.php");

$request = RequestEngine::getInstance();
$request->registerReferer();

require_once ("header.php");

require_once ("navigation.php");

$ui = new Panel(30, 30);
$ui->title->setText("ColumnLayout");
$ui->setPosition(-33, 45, 1);
$ui->save();

$layout = new ColumnLayout($ui);
$layout->setMarginHeight(1);
$layout->setBorder(1, 6);
{
	$ui = new Quad(5, 5);
	$layout->add($ui);

	$ui = new Quad(5, 5);
	$layout->add($ui);

	$ui = new Quad(5, 5);
	$layout->add($ui);
}
$layout->save();

$ui = new Panel(30, 30);
$ui->title->setText("LineLayout");
$ui->setPosition(0, 45, 1);
$ui->save();

$layout = new LineLayout($ui);
$layout->setMarginWidth(1);
$layout->setBorder(1, 6);
{
	$ui = new Quad(5, 5);
	$layout->add($ui);

	$ui = new Quad(5, 5);
	$layout->add($ui);

	$ui = new Quad(5, 5);
	$layout->add($ui);
}
$layout->save();

require_once ("footer.php");
?>

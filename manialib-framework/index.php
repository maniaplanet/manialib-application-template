<?php
/**
 * @author Maxime Raoust
 */

 
require_once("core.inc.php");

$ui = new Manialink;
$ui->draw();

$ui = new Label;
$ui->setText("Hello world");
$ui->draw();

Manialink::theEnd();


?>
<?php
/**
 * @author Maxime Raoust
 */

 
require_once("core.inc.php");

Manialink::load();

$ui = new Label;
$ui->setText("Hello world");
$ui->save();

Manialink::render();


?>
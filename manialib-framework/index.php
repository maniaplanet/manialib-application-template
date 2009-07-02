<?php
/**
 * @author Maxime Raoust
 */

 
require_once("core.inc.php");

Manialink::load();

$ui = new Label;
$ui->setText("Hello world");
$ui->draw();

Manialink::render();


?>
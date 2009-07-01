<?php
/**
 * Connection page
 * @author Maxime Raoust
 * @package auto_connect
 */

require_once("core.inc.php");

$request = RequestEngine::getInstance();

require_once("header.php");

	Manialink::beginFrame(0, 0, 1);
	
		$ui = new Button;
		$ui->setAlign("center", "center");
		$ui->setScale(2);
		$ui->setText("Connect");
		$ui->setManialink($request->getReferer());
		$ui->addPlayerId();
		$ui->save();
	
	Manialink::endFrame();

require_once("footer.php");

?>
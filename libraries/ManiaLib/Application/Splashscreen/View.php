<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Base view for the splash screen. Override that.
 */
class ManiaLib_Application_Splashscreen_View extends ManiaLib_Application_View
{
	function display()
	{
		$ui = new Button();
		$ui->setAlign('center', 'center');
		$ui->setPosition(0, 0, 5);
		$ui->setStyle(Button::CardButtonMediumWide);
		$ui->setManialink($this->response->enterManialink);
		$ui->addPlayerId();
		$ui->setText('Enter');
		$ui->save();
	}
}

?>
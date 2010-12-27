<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 */
class ManiaLibDemo_Views_Home_Download extends ManiaLib_Application_View
{
	function display()
	{
		$this->renderSubView('Navigation');
		
		Manialink::beginFrame(-20, 35, 1);
		{
			$ui = new FancyPanel(70, 50);
			$ui->setSubStyle(Bgs1::BgWindow2);
			$ui->title->setText(__('download'));
			$ui->subtitle->setText(__('howto_get_manialib'));
			$ui->icon->setSubStyle(Icons128x128_1::Load);
			$ui->save();
			
			$ui = new Label(62);
			$ui->setPosition(3, -15, 1);
			$ui->enableAutonewline();
			$ui->setStyle(Label::TextValueMedium);
			$ui->setText(__('goto_project_website_explanation'));
			$ui->save();
			
			$ui = new Button;
			$ui->setHalign('center');
			$ui->setPosition(35, -30, 1);
			$ui->setScale(1.35);
			$ui->setUrl('http://code.google.com/p/manialib/');
			$ui->setText(__('goto_project_website'));
			$ui->save();
		}
		Manialink::endFrame();
	}
}

?>
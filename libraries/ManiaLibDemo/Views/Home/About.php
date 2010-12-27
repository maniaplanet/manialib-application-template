<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 */
class ManiaLibDemo_Views_Home_About extends ManiaLib_Application_View
{
	function display()
	{
		$this->renderSubView('Navigation');
		
		Manialink::beginFrame(-20, 35, 1);
		{
			$ui = new FancyPanel(70, 50);
			$ui->setSubStyle(Bgs1::BgWindow2);
			$ui->title->setText(__('about'));
			$ui->subtitle->setText(__('what_is_manialib'));
			$ui->icon->setSubStyle(Icons128x128_1::Custom);
			$ui->save();
			
			Manialink::beginFrame(0, -15, 1);
			{
				$ui = new Label(60);
				$ui->setHalign('center');
				$ui->setPosition(35, 0, 0);
				$ui->enableAutonewline();
				$ui->setTextColor('ff0');
				$ui->setTextSize(4);
				$ui->setText('$o$i'.__('manialib_helps_php_programmers').'$z');
				$ui->save();
				
				$ui = new Label(62);
				$ui->setPosition(3, -12, 0);
				$ui->enableAutonewline();
				$ui->setStyle(Label::TextValueMedium);
				$ui->setText(__('manialib_explanation'));
				$ui->save();
			}
			Manialink::endFrame();
		}
		Manialink::endFrame();
	}
}

?>
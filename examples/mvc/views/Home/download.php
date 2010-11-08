<?php 
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

View::render('Home', '_navigation');

////////////////////////////////////////////////////////////////////////////////
// "Download" panel
////////////////////////////////////////////////////////////////////////////////
Manialink::beginFrame(-20, 35, 1);
{
	$ui = new Quad(70, 50);
	$ui->setSubStyle(Bgs1::BgWindow2);
	$ui->save();
	
	Manialink::beginFrame(2, -3, 1);
	{
		$ui = new Quad(8, 8);
		$ui->setStyle(Quad::Icons128x128_1);
		$ui->setSubStyle(Icons128x128_1::Load);
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -0.5, 0);
		$ui->setStyle(Label::TextRankingsBig);
		$ui->setText(__('download'));
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -4, 0);
		$ui->setStyle(Label::TextInfoSmall);
		$ui->setText(__('howto_get_manialib'));
		$ui->save();
	}
	Manialink::endFrame();
	
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

?>
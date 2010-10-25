<?php 
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO
 */

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

View::render('Home', '_navigation');

////////////////////////////////////////////////////////////////////////////////
// "Features" panel
////////////////////////////////////////////////////////////////////////////////
Manialink::beginFrame(-20, 35, 1);
{
	$ui = new Quad(70, 70);
	$ui->setSubStyle(Bgs1::BgWindow2);
	$ui->save();
	
	Manialink::beginFrame(2, -3, 1);
	{
		$ui = new Quad(8, 8);
		$ui->setStyle(Quad::Icons128x128_1);
		$ui->setSubStyle(Icons128x128_1::Forever);
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -0.5, 0);
		$ui->setStyle(Label::TextRankingsBig);
		$ui->setText(__('features'));
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -4, 0);
		$ui->setStyle(Label::TextInfoSmall);
		$ui->setText(__('whats_in_manialib'));
		$ui->save();
	}
	Manialink::endFrame();
	
	$layout = new ColumnLayout();
	$layout->setMarginHeight(2);
	
	Manialink::beginFrame(4, -15, 1, $layout);
	{
		for($i=1; $i<=7; $i++)
		{
			$ui = new BulletCard(62);
			$ui->bullet->setSubStyle(Icons128x128_1::Advanced);
			$ui->title->setText(__('features_bullet'.$i));
			$ui->save();
		}
	}
	Manialink::endFrame();
}
Manialink::endFrame();

?>
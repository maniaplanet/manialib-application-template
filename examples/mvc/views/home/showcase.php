<?php 
/**
 * @author Maxime Raoust
 * @copyright NADEO
 */

$request = RequestEngineMVC::getInstance();
$response = ResponseEngine::getInstance();

View::render('home', '_navigation');

////////////////////////////////////////////////////////////////////////////////
// "Showcase" panel
////////////////////////////////////////////////////////////////////////////////
Manialink::beginFrame(-15, 35, 1);
{
	$ui = new Quad(70, 50);
	$ui->setSubStyle(Bgs1::BgWindow2);
	$ui->save();
	
	Manialink::beginFrame(2, -3, 1);
	{
		$ui = new Quad(8, 8);
		$ui->setStyle(Quad::Icons128x128_1);
		$ui->setSubStyle(Icons128x128_1::ServersSuggested);
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -0.5, 0);
		$ui->setStyle(Label::TextRankingsBig);
		$ui->setText('Showcase');
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -4, 0);
		$ui->setStyle(Label::TextInfoSmall);
		$ui->setText('Who is using ManiaLib?');
		$ui->save();
	}
	Manialink::endFrame();
	
	$ui = new Quad(60, 20);
	$ui->setPosition(5, -15, 0);
	$ui->setSubStyle(Bgs1::BgList);
	$ui->save();
	
	$ui = new Label(29);
	$ui->setPosition(7, -17, 1);
	$ui->enableAutonewline();
	$ui->setText(
		'$o'.
		'$hManialink:Home$h'."\n".
		'$hManiaPub$h'."\n".
		'$hManiaHome$h'."\n".
		'$hManiaSpace$h'."\n".
		'$hManiaTeam$h'."\n".
		'$hManiaHost$h'."\n");
	$ui->save();
}
Manialink::endFrame();

?>
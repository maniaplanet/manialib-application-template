<?php
/**
 * @author Maxime Raoust
 */
 
require_once(dirname(__FILE__).'/core.inc.php');

$request = RequestEngine::getInstance();
$request->registerReferer();

require_once(APP_WWW_PATH.'header.php');
require_once(APP_WWW_PATH.'navigation.php');

////////////////////////////////////////////////////////////////////////////////
// "About" panel
////////////////////////////////////////////////////////////////////////////////
Manialink::beginFrame(15, 37, 1);
{
	$ui = new Quad(70, 32);
	$ui->setHalign('center');
	$ui->setSubStyle(Bgs1::BgWindow2);
	$ui->save();
	
	Manialink::beginFrame(-32, -3, 1);
	{
		$ui = new Quad(8, 8);
		$ui->setImage('logo64.dds');
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -0.5, 0);
		$ui->setStyle(Label::TextRankingsBig);
		$ui->setText('About');
		$ui->save();
		
		$ui = new Label(50);
		$ui->setPosition(9, -4, 0);
		$ui->setStyle(Label::TextInfoSmall);
		$ui->setText('What is ManiaLib?');
		$ui->save();
		
		$ui = new Label(64);
		$ui->setPosition(0, -10, 0);
		$ui->enableAutonewline();
		$ui->setText(
			'$o$i$ff0ManiaLib helps PHP programmers create '.
			'dynamic Manialinks faster.$z'."\n\n".
			'In more technical terms, ManiaLib is a $olightweight '.
			'PHP framework$o for the development of Manialinks. '.
			'The framework\'s core contains a set '.
			'of object-oriented libraries, but the philosphy is '.
			'to keep the application code simple.');
		$ui->save();
	}
	Manialink::endFrame();
}
Manialink::endFrame();

////////////////////////////////////////////////////////////////////////////////
// "Showcase" panel
////////////////////////////////////////////////////////////////////////////////
Manialink::beginFrame(-20, 3, 1);
{
	$ui = new Quad(35, 40);
	$ui->setSubStyle(Bgs1::BgWindow2);
	$ui->save();
	
	Manialink::beginFrame(2, -2, 1);
	{
		$ui = new Quad(8, 8);
		$ui->setStyle(Quad::Icons128x128_1);
		$ui->setSubStyle(Icons128x128_1::Manialink);
		$ui->save();
		
		$ui = new Label(25);
		$ui->setPosition(9, -0.5, 0);
		$ui->setStyle(Label::TextRankingsBig);
		$ui->setText('Showcase');
		$ui->save();
		
		$ui = new Label(25);
		$ui->setPosition(9, -4, 0);
		$ui->setStyle(Label::TextInfoSmall);
		$ui->setText('Who is using ManiaLib?');
		$ui->save();
		
		$ui = new Quad(31, 27);
		$ui->setPosition(0, -8, 0);
		$ui->setSubStyle(Bgs1::BgList);
		$ui->save();
		
		$ui = new Label(29);
		$ui->setPosition(2, -10, 1);
		$ui->enableAutonewline();
		$ui->setText(
			'$o'.
			'$hManialink:Home$h'."\n".
			'$hManiaPub$h'."\n".
			'$hManiaHome$h'."\n".
			'$hManiaSpace$h'."\n".
			'$hManiaTeam$h'."\n".
			'$hManialink:Home$h'."\n");
		$ui->save();
	}
	Manialink::endFrame();
}
Manialink::endFrame();

////////////////////////////////////////////////////////////////////////////////
// "Download" panel
////////////////////////////////////////////////////////////////////////////////
Manialink::beginFrame(17, 3, 1);
{
	$ui = new Quad(33, 40);
	$ui->setSubStyle(Bgs1::BgWindow2);
	$ui->save();
	
	Manialink::beginFrame(2, -2, 1);
	{
		$ui = new Quad(8, 8);
		$ui->setStyle(Quad::Icons128x128_1);
		$ui->setSubStyle(Icons128x128_1::Load);
		$ui->save();
		
		$ui = new Label(25);
		$ui->setPosition(9, -0.5, 0);
		$ui->setStyle(Label::TextRankingsBig);
		$ui->setText('Download');
		$ui->save();
		
		$ui = new Label(25);
		$ui->setPosition(9, -4, 0);
		$ui->setStyle(Label::TextInfoSmall);
		$ui->setText('Where to get it?');
		$ui->save();
		
		$ui = new Label(29);
		$ui->setPosition(1, -10, 1);
		$ui->enableAutonewline();
		$ui->setText(
			'Visit the project\'s page on Google Code to download the latest'.
			'version of Manialib. You will also find examples and documentation.');
		$ui->save();
		
		$ui = new Button;
		$ui->setPosition(1, -25, 1);
		$ui->setUrl('http://code.google.com/p/manialib/');
		$ui->setText('Go to the project\'s website');
		$ui->save();
		
	}
	Manialink::endFrame();
}
Manialink::endFrame();

require_once(APP_WWW_PATH.'footer.php');

?>
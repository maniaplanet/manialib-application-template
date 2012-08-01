<?php

// Use statements helps keep code clean and simple
// See: http://www.php.net/manual/en/language.namespaces.php
use ManiaLib\Gui\Cards\Panel;
use ManiaLib\Gui\Elements\Bgs1;
use ManiaLib\Gui\Elements\Button;
use ManiaLib\Gui\Elements\Icons128x128_1;
use ManiaLib\Gui\Elements\Label;
use ManiaLib\Gui\Elements\Quad;
use ManiaLib\Gui\Manialink;

// You always need to require autoload.php to load ManiaLib
require_once __DIR__.'/../libraries/autoload.php';

// Always do this prior to handling GUI-related stuff. It loads everything the package needs.
// Brackets are optional, but help keep the code easy to read
Manialink::load();
{
	// This creates a background quad
	$ui = new Quad(320, 180);
	$ui->setAlign('center', 'center');
	$ui->setBgcolor('00f2'); // You may use $ui->setImage(); to have an image instead
	$ui->save();

	// Navigation menu
	require __DIR__.'/navigation-menu.php';

	// This is the first (and most simple) way to create a frame
	Manialink::beginFrame(40, 50, 0.1);
	{
		// Panel are an assembly of multiple elements. We call those aggregates "cards".
		$ui = new Panel(160, 100);
		$ui->setHalign('center');
		$ui->titleBg->setSubStyle(Bgs1::BgTitle3_1);
		$ui->title->setText('Lorem ipsum dolot sit amet');
		$ui->save();

		// This frame helps placing content inside the panel
		Manialink::beginFrame(-70, -30, 1);
		{
			$ui = new Label(140);
			$ui->enableAutonewline();
			$ui->setStyle(Label::TextTips);
			$ui->setText(
				'Lorem ipsum dolor sit amet, consectetur adipiscing elit. Curabitur facilisis, nunc pretium luctus '.
				'tristique, purus mi facilisis eros, nec scelerisque nibh lorem quis nisl. Fusce hendrerit dapibus '.
				'diam, id accumsan libero eleifend malesuada. Etiam mi urna, dictum nec vestibulum commodo, blandit eu '.
				'nibh.');
			$ui->save();

			// An icon, because icons are cool
			$ui = new Icons128x128_1(10);
			$ui->setValign('center');
			$ui->setPosition(0, -30, 0);
			$ui->setSubStyle(Icons128x128_1::Advanced);
			$ui->save();

			// A button, because buttons are cool
			$ui = new Button();
			$ui->setValign('center');
			$ui->setPosition(15, -30, 0);
			$ui->setStyle(Button::CardButtonMediumWide);
			$ui->setManialink('manialoto');
			$ui->setText('Visit ManiaLoto');
			$ui->save();
		}
		Manialink::endFrame();
	}
	Manialink::endFrame();
}
Manialink::render();
?>
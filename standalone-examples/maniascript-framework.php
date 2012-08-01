<?php

use ManiaLib\Gui\Elements\Button;
use ManiaLib\Gui\Elements\Entry;
use ManiaLib\Gui\Elements\IncludeManialink;
use ManiaLib\Gui\Layouts\Column;
use ManiaLib\Gui\Manialink;
use ManiaLib\ManiaScript\Action;
use ManiaLib\ManiaScript\Main;
use ManiaLib\ManiaScript\UI;

require_once __DIR__.'/../libraries/autoload.php';

Manialink::load();
{
	// First you need to include this file to load the ManiaScript framework
	$ui = new IncludeManialink();
	$ui->setUrl('../media/maniascript/manialib.xml');
	$ui->save();

	// Before you do anything with the ManiaScript framework, you need to begin the main() function
	Main::begin();

	// Navigation menu
	require __DIR__.'/navigation-menu.php';

	$layout = new Column();
	$layout->setMarginHeight(2);

	Manialink::beginFrame(40, 25, 0, 1, $layout);
	{
		$ui = new Button();
		$ui->setHalign('center');
		$ui->setId('button1');
		$ui->setScriptEvents();
		$ui->setText('Show tooltip');
		$ui->save();

		UI::tooltip('button1', 'This is a tooltip');

		$ui = new Button();
		$ui->setHalign('center');
		$ui->setId('button2');
		$ui->setScriptEvents();
		$ui->setText('Show dialog');
		$ui->save();

		UI::dialog('button2', 'Do you want to visit ManiaLoto?', array(Action::manialink, 'manialoto'));

		$ui = new Button();
		$ui->setHalign('center');
		$ui->setId('button3');
		$ui->setScriptEvents();
		$ui->setText('Pick a date');
		$ui->save();

		$ui = new Entry(35, 7);
		$ui->setHalign('center');
		$ui->setId('date');
		$ui->save();

		UI::datePicker('date', 'button3');
	}
	Manialink::endFrame();

	// At the end, place the main() loop that listens to and execute events
	Main::loop();

	// Don't forget to close the main() function
	Main::end();
}
Manialink::render();
?>
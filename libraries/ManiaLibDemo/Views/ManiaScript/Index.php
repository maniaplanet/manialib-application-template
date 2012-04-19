<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @see         http://code.google.com/p/manialib/
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLibDemo\Views\ManiaScript;

use ManiaLib\Gui\Manialink;
use ManiaLib\ManiaScript\UI;
use ManiaLib\ManiaScript\Action;
use ManiaLib\ManiaScript\Main;
use ManiaLib\ManiaScript\Event;
use ManiaLib\Application\Tracking\EventTracker;

class Index extends \ManiaLib\Application\View
{

	function display()
	{
		$ui = new \ManiaLib\Gui\Elements\IncludeManialink();
		$ui->setUrl('manialib.xml', false);
		$ui->save();

		Main::begin();

		Manialink::beginFrame(0, 0, 0, 1, new \ManiaLib\Gui\Layouts\Column());
		{
			EventTracker::trackNow('ManiaHomeButton', 'Displayed', 'Go to maniahome');
			EventTracker::trackAsnyc('ManiaHomeButton', 'Clicked', 'Go to maniahome',
				'maniahome-button', Event::mouseClick);

			$ui = new \ManiaLib\Gui\Elements\Button();
			$ui->setAlign('center', 'center');
			$ui->setText('Go to ManiaHome');
			$ui->setId('maniahome-button');
			$ui->setScriptEvents();
			$ui->save();

			UI::dialog('maniahome-button', 'Do you want to visit ManiaHome?',
				array(Action::manialink, "maniahome"));
			UI::tooltip('maniahome-button', 'Click me! Click me!');

			$ui = new \ManiaLib\Gui\Elements\Button();
			$ui->setAlign('center', 'center');
			$ui->setText('Go to ManiaLoto');
			$ui->setId('manialoto-button');
			$ui->setScriptEvents();
			$ui->save();

			UI::dialog('manialoto-button',
				'Do you want to visit ManiaLo\to?'."\n".'Hmmm kay?',
				array(Action::manialink, "manialoto"));
			UI::tooltip('manialoto-button', 'Click me too!');
		}
		Manialink::endFrame();

		Main::loop();
		Main::end();
	}

}

?>
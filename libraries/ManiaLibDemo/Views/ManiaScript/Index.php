<?php
/**
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLibDemo\Views\ManiaScript;

use ManiaLib\Gui\Manialink;
use ManiaLib\ManiaScript\UI;
use ManiaLib\ManiaScript\Action;

class Index extends \ManiaLib\Application\View
{

	function display()
	{
		$ui = new \ManiaLib\Gui\Elements\IncludeManialink();
		$ui->setUrl('manialib2.xml', false);
		$ui->save();
		
		Manialink::appendScript('main() {');
		
		$ui = new \ManiaLib\Gui\Elements\Button();
		$ui->setAlign('center', 'center');
		$ui->setText('Go to ManiaHome');
		$ui->setId('maniahome-button');
		$ui->setScriptEvents();
		$ui->save();
		
		UI::dialog('maniahome-button', 'Do you want to visit ManiaHome?', array(Action::manialink, "maniahome"));
		UI::tooltip('maniahome-button', 'Click me! Click me!');
		
		Manialink::appendScript('manialib_main_loop();');
		Manialink::appendScript('}');
	}

}

?>
<?php
/**
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLibDemo\Views\ManiaScript;

use ManiaLib\Gui\Manialink;

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
		
		Manialink::appendScript('manialib_ui_dialog("maniahome-button", "Do you want to go to maniahome?", ["manialink", "maniahome"]);');
		Manialink::appendScript('manialib_ui_tooltip("maniahome-button", "Click me! Click me");');
		
		Manialink::appendScript('manialib_main_loop();');
		Manialink::appendScript('}');
	}

}

?>
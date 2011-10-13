<?php
/**
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLibDemo\Views\Home;

use ManiaLib\Gui\Manialink;
use ManiaLib\Gui\Elements\Button;

class SomePage extends \ManiaLib\Application\View
{

	function display()
	{
		Manialink::beginFrame(-40, 20, 0);
		{
			$ui = new \ManiaLib\Gui\Cards\Panel(80, 50);
			$ui->title->setText('Some page');
			$ui->save();

			$manialink = $this->request->createLink('/');

			$ui = new Button();
			$ui->setHalign('center');
			$ui->setPosition(40, -40, 1);
			$ui->setText('Back');
			$ui->setManialink($manialink);
			$ui->save();
		}
		Manialink::endFrame();
	}

}

?>
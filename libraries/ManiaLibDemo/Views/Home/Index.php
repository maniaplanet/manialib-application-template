<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLibDemo\Views\Home;

use ManiaLib\Gui\Manialink;
use ManiaLib\Gui\Elements\Label;
use ManiaLib\Gui\Elements\Button;

class Index extends \ManiaLib\Application\View
{

	function display()
	{
		Manialink::beginFrame(0, 15, 0);
		{
			$ui = new Label(100);
			$ui->setHalign('center');
			$ui->setText('Hello world!');
			$ui->save();
			
			$manialink = $this->request->createLink('/home/some-page');
			
			$ui = new Button();
			$ui->setHalign('center');
			$ui->setPosition(0, -10, 0);
			$ui->setText('Go to some page');
			$ui->setManialink($manialink);
			$ui->save();
		}
		Manialink::endFrame();
	}

}

?>
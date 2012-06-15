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

			Manialink::beginFrame(13, 37, 42, 1, new \ManiaLib\Gui\Layouts\Line());
			{
				$ui = new \ManiaLib\Gui\Elements\Quad(10, 10);
				$ui->save();

				$ui = new \ManiaLib\Gui\Elements\Quad(10, 10);
				$ui->save();

				$ui = new \ManiaLib\Gui\Elements\Quad(10, 10);
				$ui->save();

				$ui = new \ManiaLib\Gui\Elements\Quad(10, 10);
				$ui->save();

				$ui = new \ManiaLib\Gui\Elements\Quad(10, 10);
				$ui->save();

				$ui = new \ManiaLib\Gui\Elements\Quad(10, 10);
				$ui->save();
			}
			Manialink::beginFrame();

			$f = new \ManiaLib\Gui\Elements\Frame(0, 0);
			$f->setPosition(42, 42, 42);
			
			$ui = new \ManiaLib\Gui\Elements\Bgs1();
			$f->add($ui);
			
			$f->save();
		}
		Manialink::endFrame();
	}

}

?>
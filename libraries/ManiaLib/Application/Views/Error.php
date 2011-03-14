<?php 
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 1709 $:
 * @author      $Author: svn $:
 * @date        $Date: 2011-01-07 14:06:13 +0100 (ven., 07 janv. 2011) $:
 */

namespace ManiaLib\Application\Views;

use ManiaLib\Gui\Elements\Button;
use ManiaLib\Gui\Elements\Bgs1;
use ManiaLib\Gui\Elements\Label;
use ManiaLib\Gui\Cards\Panel;
use ManiaLib\Gui\Manialink;

/**
 * Default error page
 */
class Error extends \ManiaLib\Application\View
{
	function display()
	{
		$width = $this->response->get('width', 70);
		$height =  $this->response->get('height', 35);
		$message = $this->response->message;
		$message = $message ?: '$<$oOops!$>'."\n".'An error occured.';
		
		Manialink::load();
		{
			$ui = new Panel($width, $height);
			$ui->setAlign('center', 'center');
			$ui->title->setStyle(Label::TextTitleError);
			$ui->titleBg->setSubStyle(Bgs1::BgTitle2);
			$ui->title->setText('Error');
			$ui->save();

			$ui = new Label(68);
			$ui->enableAutonewline();
			$ui->setAlign('center', 'center');
			$ui->setPosition(0, 0, 2);
			$ui->setText($message);
			$ui->save();
			
			$ui = new Button();
			$ui->setText('Back');
			$ui->setManialink($this->response->backLink);
			$ui->setPosition(0, -($height/2)+5, 5);
			$ui->setHalign('center');
			$ui->save();
		}
		Manialink::render();
	}
}

?>
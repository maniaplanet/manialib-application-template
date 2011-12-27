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

namespace ManiaLib\Application\Tracking;

use ManiaLib\Gui\Elements\Quad;

class View extends \ManiaLib\Application\View
{

	function display()
	{
		if($this->response->trackingURL)
		{
			$ui = new Quad(0.1, 0.1);
			$ui->setPosition(400, 300);
			$ui->setImage($this->response->trackingURL, true);
			$ui->save();
		}
	}

}

?>
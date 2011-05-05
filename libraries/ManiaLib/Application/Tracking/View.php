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

namespace ManiaLib\Application\Tracking;

use ManiaLib\Gui\Elements\Quad;

/**
 * Tracking view
 */
class View extends \ManiaLib\Application\View
{

	function display()
	{
		if($this->response->trackingURL)
		{
			$ui = new Quad(0, 0);
			$ui->setPosition(200, 200);
			$ui->setImage($this->response->trackingURL, true);
			$ui->save();
		}
	}

}

?>
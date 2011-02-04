<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision: 1870 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-01-17 13:22:21 +0100 (lun., 17 janv. 2011) $:
 */

namespace ManiaLib\Gui\Cards;

use ManiaLib\Gui\Elements\Label;
use ManiaLib\Gui\Elements\Bgs1;

/**
 * Simple card
 * A bgs1 quad (typically a BgCardXxx) with a text on it
 */
class Simple extends Bgs1
{
	/**
	 * @var \ManiaLib\Gui\Elements\Label
	 */
	public $text;
	
	function __construct($sizeX = 30, $sizeY = 4.5)
	{
		parent::__construct($sizeX, $sizeY);
		
		$this->setSubStyle(Bgs1::BgCardSystem);
		
		$this->cardElementsValign = 'center';
		
		$this->text = new Label($sizeX - 4);
		$this->text->setAlign('left', 'center');
		$this->text->setStyle(Label::TextChallengeNameSmall);
		$this->text->setPosition(3, 0.25);
		$this->addCardElement($this->text);
	}
}


?>
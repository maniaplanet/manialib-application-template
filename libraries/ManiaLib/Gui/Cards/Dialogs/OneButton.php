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

namespace ManiaLib\Gui\Cards\Dialogs;

/**
 * Dialog box with 1 button
 */
class OneButton extends \ManiaLib\Gui\Cards\Panel
{
	/**
	 * @var \ManiaLib\Gui\Elements\Button
	 */
	public $button;
	/**
	 * @var \ManiaLib\Gui\Elements\Label
	 */
	public $text;
	/**
	 * @ignore
	 */
	protected $elementsToShow = array();
	
	function __construct($sizeX = 65, $sizeY = 25)
	{
		parent::__construct($sizeX, $sizeY);
		
		$this->setSubStyle(\ManiaLib\Gui\Elements\Bgs1::BgTitle2);
		$this->title->setStyle(\ManiaLib\Gui\Elements\Label::TextTitle2);
		$this->addCardElement($this->title);
		
		$this->button = new \ManiaLib\Gui\Elements\Button;
		$this->button->setAlign('center', 'bottom');
		$this->addCardElement($this->button);
		
		$this->text = new \ManiaLib\Gui\Elements\Label($this->sizeX - 6, $this->sizeY - 11);
		$this->text->setAlign('left', 'top');
		$this->addCardElement($this->text);
	}
	
}

?>
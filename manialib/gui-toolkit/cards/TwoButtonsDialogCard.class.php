<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * Dialog
 * Dialog box with 2 buttons
 * @package ManiaLib
 * @subpackage GUIToolkit_Cards
 */
class TwoButtonsDialogCard extends DialogCard
{
	public $button2;
	
	function __construct($sizeX = 65, $sizeY = 25)
	{
		parent::__construct($sizeX, $sizeY);
		
		$this->button->setPosition(-15, 0, 0);
		
		$this->button2 = new Button;
		$this->button2->setPosition(15, 0, 0);
		$this->button2->setAlign('center', 'bottom');
		$this->elementsToShow[] = $this->button2;
	}
}

?>
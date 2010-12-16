<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Dialog
 * Dialog box with 2 buttons
 */
class ManiaLib_Gui_Cards_Dialogs_TwoButtons extends ManiaLib_Gui_Cards_Dialogs_OneButton
{
	/**
	 * @var ManiaLib_Gui_Elements_Button
	 */
	public $button2;
	
	function __construct($sizeX = 65, $sizeY = 25)
	{
		parent::__construct($sizeX, $sizeY);
		
		$this->button->setPosition(-15, 0, 0);
		
		$this->button2 = new ManiaLib_Gui_Elements_Button;
		$this->button2->setPosition(15, 0, 0);
		$this->button2->setAlign('center', 'bottom');
		$this->elementsToShow[] = $this->button2;
	}
}

?>
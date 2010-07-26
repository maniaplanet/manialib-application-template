<?php
/**
 * @author Philippe Melot
 * @copyright Nadeo
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
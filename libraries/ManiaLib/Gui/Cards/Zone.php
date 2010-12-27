<?php 
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Zone card
 */ 
class ManiaLib_Gui_Cards_Zone extends ManiaLib_Gui_Elements_Quad
{
	/**
	 * @var ManiaLib_Gui_Elements_Label
	 */
	public $name;
	/**
	 * @var ManiaLib_Gui_Elements_Quad
	 */
	public $flag;
	
	function __construct($sizeX=28, $sizeY=5)
	{
		parent::__construct($sizeX,$sizeY);
		
		$this->setSubStyle(ManiaLib_Gui_Elements_Bgs1::BgCard2);
		$this->cardElementsValign = 'center';
		
		$this->flag = new ManiaLib_Gui_Elements_Quad($this->sizeY-1.5, $this->sizeY-1.5);
		$this->flag->setValign('center');
		$this->flag->setPositionX(3);
		$this->addCardElement($this->flag);
		
		$this->name = new ManiaLib_Gui_Elements_Label($this->sizeX - $this->sizeY - 7);
		$this->name->setValign('center');
		$this->name->setStyle(ManiaLib_Gui_Elements_Label::TextChallengeNameMedium);
		$this->name->setPositionX($this->sizeY+4);
		$this->addCardElement($this->name);
	}
}

?>
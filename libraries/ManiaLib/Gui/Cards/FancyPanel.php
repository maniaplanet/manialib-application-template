<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Fancy panel
 */
class ManiaLib_Gui_Cards_FancyPanel extends ManiaLib_Gui_Elements_Bgs1
{
	/**
	 * @var ManiaLib_Gui_Elements_Label
	 */
	public $title;
	/**
	 * @var ManiaLib_Gui_Elements_Label
	 */
	public $subtitle;
	/**
	 * @var ManiaLib_Gui_Elements_Icons128x128_1
	 */
	public $icon;
		
	function __construct ($sizeX=70, $sizeY=60)
	{	
		parent::__construct($sizeX, $sizeY);
		
		$this->cardElementsPosX = 2;
		$this->cardElementsPosY = -3;
		
		$this->icon = new ManiaLib_Gui_Elements_Icons128x128_1(8);
		$this->addCardElement($this->icon);
		
		$this->title = new ManiaLib_Gui_Elements_Label($sizeX - 10, 5);
		$this->title->setStyle(Label::TextRankingsBig);
		$this->addCardElement($this->title);
		
		$this->subtitle = new ManiaLib_Gui_Elements_Label($sizeX - 10, 3);
		$this->subtitle->setStyle(Label::TextInfoSmall);
		$this->addCardElement($this->subtitle);
	}
	
	protected function preFilter()
	{
		$this->title->incPosX($this->icon->getSizeX()+1);
		$this->title->incPosY(-0.5);
		$this->subtitle->incPosX($this->icon->getSizeX()+1);
		$this->subtitle->incPosY(-4);
	}
	
}


?>
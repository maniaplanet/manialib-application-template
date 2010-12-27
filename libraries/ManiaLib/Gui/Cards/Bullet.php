<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Bullet
 * Bullet to make nice lists
 */
class ManiaLib_Gui_Cards_Bullet extends ManiaLib_Gui_Elements_Spacer
{
	/**
	 * @var ManiaLib_Gui_Elements_Quad
	 */
	public $bg;
	/**
	 * @var ManiaLib_Gui_Elements_Icon
	 */
	public $bullet;
	/**
	 * @var ManiaLib_Gui_Elements_Label
	 */
	public $title;
	
	function __construct($sizeX = 50, $sizeY = 8)
	{
		parent::__construct($sizeX, $sizeY);
		
		$this->cardElementsValign = 'center';
		
		$this->bg = new ManiaLib_Gui_Elements_Quad($sizeX, 5);
		$this->bg->setValign('center');
		$this->bg->setSubStyle(ManiaLib_Gui_Elements_Bgs1::BgList);
		$this->addCardElement($this->bg);
		
		$this->bullet = new ManiaLib_Gui_Elements_Icon(8);
		$this->bullet->setValign('center');
		$this->bullet->setPosition(0.5, -0.1, 1);
		$this->addCardElement($this->bullet);
		
		$this->title = new ManiaLib_Gui_Elements_Label();
		$this->title->setValign('center');
		$this->title->setPosition(0, 0.1, 1);
		$this->title->setStyle(ManiaLib_Gui_Elements_Label::TextTitle3);
		$this->addCardElement($this->title);
	}
	
	/**
	 * @ignore
	 */
	protected function preFilter()
	{
		$this->title->setPositionX($this->title->getPosX() + 9.5);
		$this->title->setSizeX($this->getSizeX() - $this->title->getPosX() - 2);
	}
}
?>
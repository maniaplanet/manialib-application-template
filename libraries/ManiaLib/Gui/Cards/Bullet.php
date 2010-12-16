<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * Bullet
 * Bullet to make nice lists
 * @package ManiaLib
 * @subpackage GUIToolkit_Cards
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
		
		$this->bg = new ManiaLib_Gui_Elements_Quad($sizeX, 5);
		$this->bg->setValign('center');
		$this->bg->setSubStyle(ManiaLib_Gui_Elements_Bgs1::BgList);
		
		$this->bullet = new ManiaLib_Gui_Elements_Icon(8);
		$this->bullet->setValign('center');
		$this->bullet->setPosition(0.5, -0.1, 1);
		
		$this->title = new ManiaLib_Gui_Elements_Label();
		$this->title->setValign('center');
		$this->title->setPosition(0, 0.1, 1);
		$this->title->setStyle(ManiaLib_Gui_Elements_Label::TextTitle3);
	}
	
	/**
	 * @ignore
	 */
	function postFilter()
	{
		$this->title->setPositionX($this->title->getPosX() + 9.5);
		$this->title->setSizeX($this->getSizeX() - $this->title->getPosX() - 2);
		
		$arr = ManiaLib_Gui_Tools::getAlignedPos ($this, "left", "center");
		$x = $arr["x"];
		$y = $arr["y"];
		
		ManiaLib_Gui_Manialink::beginFrame($x, $y, $this->posZ+1);
		{
			$this->bg->save();
			$this->bullet->save();
			$this->title->save();
		}
		ManiaLib_Gui_Manialink::endFrame();
	}
}
?>
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
class BulletCard extends Quad
{
	public $bullet;
	public $title;
	
	function __construct($sizeX = 50, $sizeY = 5)
	{
		$this->sizeX = $sizeX;
		$this->sizeY = $sizeY;
		$this->setSubStyle(Bgs1::BgList);
		
		$this->bullet = new Icon(8);
		$this->bullet->setValign('center');
		$this->bullet->setPosition(0.5, -0.1, 0);
		
		$this->title = new Label();
		$this->title->setValign('center');
		$this->title->setPosition(0, 0.1, 0);
		$this->title->setStyle(Label::TextTitle3);
	}
	
	function postFilter()
	{
		$this->title->setPositionX(9.5);
		$this->title->setSizeX($this->getSizeX() - $this->title->getPosX() - 2);
		
		$arr = GuiTools::getAlignedPos ($this, "left", "center");
		$x = $arr["x"];
		$y = $arr["y"];
		
		Manialink::beginFrame($x, $y, $this->posZ+1);
		{
			$this->bullet->save();
			$this->title->save();
		}
		Manialink::endFrame();
	}
}
?>
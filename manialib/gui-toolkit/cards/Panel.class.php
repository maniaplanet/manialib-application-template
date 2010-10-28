<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * Panel
 * Very useful! A quad with a title and a title background
 * @package ManiaLib
 * @subpackage GUIToolkit_Cards
 */
class Panel extends Quad
{
	/**
	 * Reference on the title object (Label)
	 * @ignore
	 */
	public $title;
	/**
	 * Reference on the title background object (Quad)
	 * @ignore
	 */
	public $titleBg;
	
	function __construct ($sx=20, $sy=20)
	{	
		$this->sizeX = $sx;
		$this->sizeY = $sy;

		$titleBgWidth = $sx - 2;
		$titleWidth = $sx - 4;
		
		$this->setStyle(GuiDefaultStyles::Panel_Style);
		$this->setSubStyle(GuiDefaultStyles::Panel_Substyle);
		
		$this->titleBg = new Quad ($titleBgWidth, 4);
		$this->titleBg->setStyle(GuiDefaultStyles::Panel_TitleBg_Style);
		$this->titleBg->setSubStyle(GuiDefaultStyles::Panel_TitleBg_Substyle);

		$this->title = new Label ($titleWidth);
		$this->title->setStyle(GuiDefaultStyles::Panel_Title_Style);
		$this->title->setPositionY(-0.75);
	}
	
	function setSizeX($x)
	{
		parent::setSizeX($x);
		$this->titleBg->setSizeX($x-2);
		$this->title->setSizeX($x-4);
	}
	
	/**
	 * @ignore
	 */
	protected function postFilter()
	{
		// Algin the title and its bg at the top center of the main quad		
		$arr = GuiTools::getAlignedPos ($this, "center", "top");
		$x = $arr["x"];
		$y = $arr["y"];
		$this->titleBg->setHalign("center");
		$this->title->setHalign("center");
		
		// Draw them
		Manialink::beginFrame($x, $y-1, $this->posZ+1);
			$this->titleBg->save();
			$this->title->save();
		Manialink::endFrame();
	}
}

?>
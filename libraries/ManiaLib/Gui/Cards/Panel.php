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
class ManiaLib_Gui_Cards_Panel extends ManiaLib_Gui_Elements_Quad
{
	/**
	 * @var ManiaLib_Gui_Elements_Label
	 */
	public $title;
	/**
	 * Title background
	 * @var ManiaLib_Gui_Elements_Quad
	 */
	public $titleBg;
	
	function __construct ($sx=20, $sy=20)
	{	
		$this->sizeX = $sx;
		$this->sizeY = $sy;

		$titleBgWidth = $sx - 2;
		$titleWidth = $sx - 4;
		
		$this->setStyle(ManiaLib_Gui_DefaultStyles::Panel_Style);
		$this->setSubStyle(ManiaLib_Gui_DefaultStyles::Panel_Substyle);
		
		$this->titleBg = new ManiaLib_Gui_Elements_Quad ($titleBgWidth, 4);
		$this->titleBg->setStyle(ManiaLib_Gui_DefaultStyles::Panel_TitleBg_Style);
		$this->titleBg->setSubStyle(ManiaLib_Gui_DefaultStyles::Panel_TitleBg_Substyle);

		$this->title = new ManiaLib_Gui_Elements_Label ($titleWidth);
		$this->title->setStyle(ManiaLib_Gui_DefaultStyles::Panel_Title_Style);
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
		$arr = ManiaLib_Gui_Tools::getAlignedPos ($this, "center", "top");
		$x = $arr["x"];
		$y = $arr["y"];
		$this->titleBg->setHalign("center");
		$this->title->setHalign("center");
		
		// Draw them
		ManiaLib_Gui_Manialink::beginFrame($x, $y-1, $this->posZ+1);
			$this->titleBg->save();
			$this->title->save();
		ManiaLib_Gui_Manialink::endFrame();
	}
}

?>
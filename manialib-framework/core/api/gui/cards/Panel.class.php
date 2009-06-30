<?php
/**
 * Manialink GUI API
 * @author Maxime Raoust
 */

/**
 * Panel : quad with a title and a background title
 * @package gui_api
 */
class Panel extends Quad
{
	public $title;
	public $titleBg;
	
	function __construct ($sx=20, $sy=20)
	{	
		$this->sizeX = $sx;
		$this->sizeY = $sy;

		$titleBgWidth = $sx - 2;
		$titleWidth = $sx - 4;
		
		$this->setStyle(GUI_PANEL_DEFAULT_STYLE);
		$this->setSubStyle(GUI_PANEL_DEFAULT_SUBSTYLE);
		
		$this->titleBg = new Quad ($titleBgWidth, 4);
		$this->titleBg->setStyle(GUI_PANEL_TITLE_BG_DEFAULT_STYLE);
		$this->titleBg->setSubStyle(GUI_PANEL_TITLE_BG_DEFAULT_SUBSTYLE);

		$this->title = new Label ($titleWidth);
		$this->title->setStyle(GUI_PANEL_TITLE_DEFAULT_STYLE);
		$this->title->setPositionY(-0.75);
	}
	
	function setSizeX($x)
	{
		parent::setSizeX($x);
		$this->titleBg->setSizeX($x-2);
		$this->title->setSizeX($x-4);
	}
	
	protected function postFilter()
	{
		// Algin the title and its bg at the top center of the main quad		
		$arr = GuiTools::getAlignedPos ($this, "center", "top");
		$x = $arr["x"];
		$y = $arr["y"];
		$this->titleBg->setHalign("center");
		$this->title->setHalign("center");
		
		// Draw them
		Manialink::beginFrame($x, $y-1, $this->posZ+1, $this->output);
			$this->titleBg->save();
			$this->title->save();
		Manialink::endFrame($this->output);
	}
}

?>
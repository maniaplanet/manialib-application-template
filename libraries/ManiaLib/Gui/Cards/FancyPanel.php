<?php

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
		
		$this->icon = new ManiaLib_Gui_Elements_Icons128x128_1(8);
		
		$this->title = new ManiaLib_Gui_Elements_Label($sizeX - 10, 5);
		$this->title->setStyle(Label::TextRankingsBig);
		
		$this->subtitle = new ManiaLib_Gui_Elements_Label($sizeX - 10, 3);
		$this->subtitle->setStyle(Label::TextInfoSmall);
	}
	
	protected function postFilter()
	{
		$this->title->incPosX($this->icon->getSizeX()+1);
		$this->title->incPosY(-0.5);
		$this->subtitle->incPosX($this->icon->getSizeX()+1);
		$this->subtitle->incPosY(-4);
		
		$arr = ManiaLib_Gui_Tools::getAlignedPos ($this, "left", "top");
		$x = $arr["x"];
		$y = $arr["y"];
		
		ManiaLib_Gui_Manialink::beginFrame($x+2, $y-3, $this->posZ+1);
		{
			$this->icon->save();
			$this->title->save();
			$this->subtitle->save();
		}
		ManiaLib_Gui_Manialink::endFrame();
	}
	
}


?>
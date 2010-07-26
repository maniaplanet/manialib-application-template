<?php
/**
 * 
 * @author Philippe Melot
 * @copyright Nadeo
 */

class DialogCard extends Panel
{
	public $button;
	protected $elementsToShow = array();
	
	function __construct($sizeX = 65, $sizeY = 25)
	{
		parent::__construct($sizeX, $sizeY);
		
		$this->setSubStyle(Bgs1::BgTitle2);
		$this->title->setStyle(Label::TextTitle2);
		
		$this->button = new Button;
		$this->button->setAlign('center', 'bottom');
		
		$this->elementsToShow[] = $this->button;
	}
	
	protected function postFilter()
	{
		parent::postFilter();
		
		$arr = GuiTools::getAlignedPos($this, 'center', 'bottom');
		$x = $arr['x'];
		$y = $arr['y'];
		
		Manialink::beginFrame($x, $y+2, $this->posZ+1);
		{
			foreach($this->elementsToShow as $GUIElement)
			{
				$GUIElement->save();
			}
		}
		Manialink::endFrame();
	}
}

?>
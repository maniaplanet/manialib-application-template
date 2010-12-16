<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Dialog box with 1 button
 */
class ManiaLib_Gui_Cards_Dialogs_OneButton extends ManiaLib_Gui_Cards_Panel
{
	/**
	 * @var ManiaLib_Gui_Elements_Button
	 */
	public $button;
	/**
	 * @ignore
	 */
	protected $elementsToShow = array();
	
	function __construct($sizeX = 65, $sizeY = 25)
	{
		parent::__construct($sizeX, $sizeY);
		
		$this->setSubStyle(ManiaLib_Gui_Elements_Bgs1::BgTitle2);
		$this->title->setStyle(ManiaLib_Gui_Elements_Label::TextTitle2);
		
		$this->button = new ManiaLib_Gui_Elements_Button;
		$this->button->setAlign('center', 'bottom');
		
		$this->elementsToShow[] = $this->button;
	}
	
	/**
	 * @ignore
	 */
	protected function postFilter()
	{
		parent::postFilter();
		
		$arr = ManiaLib_Gui_Tools::getAlignedPos($this, 'center', 'bottom');
		$x = $arr['x'];
		$y = $arr['y'];
		
		ManiaLib_Gui_Manialink::beginFrame($x, $y+2, $this->posZ+1);
		{
			foreach($this->elementsToShow as $GUIElement)
			{
				$GUIElement->save();
			}
		}
		ManiaLib_Gui_Manialink::endFrame();
	}
}

?>
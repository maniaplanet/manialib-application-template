<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * Dialog
 * Dialog box with 1 button
 * @package ManiaLib
 * @subpackage GUIToolkit_Cards
 */
class DialogCard extends Panel
{
	/**
	 * @var Button
	 */
	public $button;
	/**
	 * @ignore
	 */
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
	
	/**
	 * @ignore
	 */
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
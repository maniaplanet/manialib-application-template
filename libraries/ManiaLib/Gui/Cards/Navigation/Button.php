<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * Navigation button
 * For the Navigation card
 * @see Navigation
 * @package ManiaLib
 * @subpackage GUIToolkit_Cards
 */ 
class ManiaLib_Gui_Cards_Navigation_Button extends ManiaLib_Gui_Elements_Quad
{
	/**
	 * TrackMania formatting string appended to the text when a button
	 * is selected (default is just a light blue color)
	 */
	static public $selectedTextStyle = '$0cf';
	
	/**
	 * @var ManiaLib_Gui_Elements_Label
	 */
	public $text;
	/**
	 * @var ManiaLib_Gui_Elements_Icon
	 */
	public $icon;
	public $iconSizeMinimizer = 1.5;
	public $textSizeMinimizer = 3;
	public $textOffset = 9;
	public $isSelected = false;
	/**
	 * @ignore
	 */
	protected $forceLinks = true;

	function __construct ($sx=29.5, $sy=8.5) 
	{
		$this->sizeX = $sx;
		$this->sizeY = $sy;	
		
		$this->setStyle(ManiaLib_Gui_DefaultStyles::NavigationButton_Style);
		$this->setSubStyle(ManiaLib_Gui_DefaultStyles::NavigationButton_Substyle);
		
		$this->text = new ManiaLib_Gui_Elements_Label();
		$this->text->setValign("center");
		$this->text->setPosition($this->textOffset, 0.25, 1);
		$this->text->setStyle(ManiaLib_Gui_DefaultStyles::NavigationButton_Text_Style);
		
		$this->icon = new ManiaLib_Gui_Elements_Icon($this->sizeY-$this->iconSizeMinimizer);
		$this->icon->setValign("center");
		$this->icon->setPosition(1, 0, 1);
		
	}
	
	/**
	 * Sets the button selected and change its styles accordingly
	 */
	function setSelected() 
	{
		$this->setSubStyle(ManiaLib_Gui_DefaultStyles::NavigationButton_Selected_Substyle);
		$this->isSelected = true;	
	}
	
	/**
	 * @ignore
	 */
	protected function postFilter ()
	{		
		if($this->isSelected)
		{	
			if($this->text->getText())
			{
				$this->text->setText(self::$selectedTextStyle.$this->text->getText());
			}
		}
		
		$this->text->setSizeX($this->sizeX - $this->text->getPosX() - $this->textSizeMinimizer);
		$this->text->setSizeY(0);
		$this->icon->setSize($this->sizeY-$this->iconSizeMinimizer, $this->sizeY-$this->iconSizeMinimizer);
		
		if($this->forceLinks)
		{
			$this->text->addLink($this);
			$this->icon->addLink($this);
		}
		$newPos = ManiaLib_Gui_Tools::getAlignedPos ($this, "left", "center");
		
		// Drawing
		ManiaLib_Gui_Manialink::beginFrame($newPos["x"], $newPos["y"], $this->posZ+1);
			$this->text->save();
			$this->icon->save();
		ManiaLib_Gui_Manialink::endFrame();
	}
}

?>
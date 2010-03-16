<?php
/**
 * @author Maxime Raoust
 * @package Manialib
 */

/**
 * Navigation button
 * @package Manialib
 */ 
class NavigationButton extends Quad
{
	public $text;
	public $icon;
	
	protected $forceLinks = true;
	protected $iconSizeMinimizer = 1.5;
	protected $textSizeMinimizer = 3;
	protected $textOffset = 9;

	function __construct ($sx=29.5, $sy=8.5) 
	{
		$this->sizeX = $sx;
		$this->sizeY = $sy;	
		
		$this->setStyle(GUI_NAVIGATION_BUTTON_DEFAULT_STYLE);
		$this->setSubStyle(GUI_NAVIGATION_BUTTON_DEFAULT_SUBSTYLE);
		
		$this->text = new Label();
		$this->text->setValign("center");
		$this->text->setPosition($this->textOffset, 0.25, 1);
		$this->text->setStyle(GUI_NAVIGATION_BUTTON_TEXT_DEFAULT_STYLE);
		
		$this->icon = new Icon($this->sizeY-$this->iconSizeMinimizer);
		$this->icon->setValign("center");
		$this->icon->setPosition(1, 0, 1);
		
	}
	
	/**
	 * Sets the button selected and change its styles accordingly
	 */
	function setSelected() 
	{
		$this->setSubStyle(GUI_NAVIGATION_BUTTON_SELECTED_DEFAULT_SUBSTYLE);
		$this->text->setStyle(GUI_NAVIGATION_BUTTON_SELECTED_TEXT_DEFAULT_STYLE);	
	}
	
	protected function postFilter ()
	{		
		$this->text->setSizeX($this->sizeX - $this->text->getPosX() - $this->textSizeMinimizer);
		$this->icon->setSize($this->sizeY-$this->iconSizeMinimizer, $this->sizeY-$this->iconSizeMinimizer);
		
		if($this->forceLinks)
		{
			$this->text->addLink($this);
			$this->icon->addLink($this);
		}
		$newPos = GuiTools::getAlignedPos ($this, "left", "center");
		
		// Drawing
		Manialink::beginFrame($newPos["x"], $newPos["y"], $this->posZ+1);
			$this->text->save();
			$this->icon->save();
		Manialink::endFrame();
	}
}

?>
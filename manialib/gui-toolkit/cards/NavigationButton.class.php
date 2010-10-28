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
class NavigationButton extends Quad
{
	/**
	 * @var Label
	 */
	public $text;
	/**
	 * @var Icon
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
		
		$this->setStyle(GuiDefaultStyles::NavigationButton_Style);
		$this->setSubStyle(GuiDefaultStyles::NavigationButton_Substyle);
		
		$this->text = new Label();
		$this->text->setValign("center");
		$this->text->setPosition($this->textOffset, 0.25, 1);
		$this->text->setStyle(GuiDefaultStyles::NavigationButton_Text_Style);
		
		$this->icon = new Icon($this->sizeY-$this->iconSizeMinimizer);
		$this->icon->setValign("center");
		$this->icon->setPosition(1, 0, 1);
		
	}
	
	/**
	 * Sets the button selected and change its styles accordingly
	 */
	function setSelected() 
	{
		$this->setSubStyle(GuiDefaultStyles::NavigationButton_Selected_Substyle);
		$this->text->setStyle(GuiDefaultStyles::NavigationButton_Selected_Text_Style);
		$this->isSelected = true;	
	}
	
	/**
	 * @ignore
	 */
	protected function postFilter ()
	{		
		if($this->isSelected)
		{
			$this->text->setText('$0cf'.$this->text->getText());
		}
		
		$this->text->setSizeX($this->sizeX - $this->text->getPosX() - $this->textSizeMinimizer);
		$this->text->setSizeY(0);
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
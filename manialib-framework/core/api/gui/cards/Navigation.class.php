<?php
/**
 * Manialink GUI API
 * @author Maxime Raoust
 */

/**
 * Navigation menu
 * @package gui_api
 */
class Navigation extends Quad
{
	public $title;
	public $subTitle;
	public $titleBg;
	public $quitButton;
	public $logo;
	protected $showQuitButton = true;
	protected $items = array();
	protected $marginHeight = 1;
	protected $yIndex = -10;
	protected $sizeX = 30;
	protected $sizeY = 96;

	function __construct () 
	{	
		$this->setStyle(GUI_NAVIGATION_DEFAULT_STYLE);
		$this->setSubStyle(GUI_NAVIGATION_DEFAULT_SUBSTYLE);
		
		$this->titleBg = new Quad ($this->sizeX-1, 7, 1);
		$this->titleBg->setStyle(GUI_NAVIGATION_TITLE_BG_DEFAULT_STYLE);
		$this->titleBg->setSubStyle(GUI_NAVIGATION_TITLE_BG_DEFAULT_SUBSTYLE);
		
		$this->title = new Label ($this->sizeX-2.5);
		$this->title->setPosition (1.5, -0.75, 2);
		$this->title->setStyle(GUI_NAVIGATION_TITLE_DEFAULT_STYLE);
		
		$this->subTitle = new Label ($this->sizeX-4);
		$this->subTitle->setPosition (1.5, -4, 3);
		$this->subTitle->setStyle(GUI_NAVIGATION_SUBTITLE_DEFAULT_STYLE);
		
		$this->quitButton = new NavigationButton ();
		$this->quitButton->text->setText("Back");
		$this->quitButton->icon->setSubStyle("Back");
		
		$this->logo = new Icon(6);
		$this->logo->setPosition (22.5, -0.5, 2);
		$this->logo->setSubStyle(null);
	}
	
	/**
	 * A a button to the menu
	 */
	function addItem() 
	{
		$item = new NavigationButton($this->sizeX-1);
		$item->setPosition(0, $this->yIndex);
		$this->items[] = $item;
		$this->yIndex -= $item->getSizeY() + $this->marginHeight;
	}
	
	/**
	 * Return the last added button
	 */
	function lastItem() 
	{
		return end($this->items);
	}
	
	/**
	 * Add a vertical gap before the next item
	 */
	function addGap($gap = 3) 
	{
		$this->yIndex -= $gap;
	}
	
	/**
	 * Hide the quit/back button
	 */
	function hideQuitButton() 
	{
		$this->showQuitButton = false;
	}
	
	protected function outputPreFilter () 
	{
		Manialink::beginFrame(-64, 48, 1, $this->output);
	}
	
	protected function outputPostFilter () 
	{
		// Draw the header	
		Manialink::beginFrame($this->posX+0.5, $this->posY-0.5, $this->posZ+1, $this->output);
		$this->titleBg->draw($this->output);
		$this->title->draw($this->output);
		$this->subTitle->draw($this->output);
		$this->logo->draw($this->output);
		
		// Draw the items
		foreach($this->items as $item) 
		{
			$item->draw($this->output);
		}
		if($this->showQuitButton) 
		{
			$this->quitButton->setSizeX($this->sizeX-1);
			$this->quitButton->setPosition(0, -$this->sizeY+$this->quitButton->getSizeY()+2);
			$this->quitButton->draw($this->output);
		}
		Manialink::endFrame($this->output);
		Manialink::endFrame($this->output);
	}	
}

/**
 * Navigation button
 * @package gui_api
 */ 
class NavigationButton extends Quad
{
	public $text;
	public $icon;
	
	protected $forceLinks = true;
	protected $iconSizeMinimizer = 1.5;
	protected $textSizeMinimizer = 3;
	protected $textXpos = 9;

	function __construct ($sx=29.5, $sy=8.5) 
	{
		$this->sizeX = $sx;
		$this->sizeY = $sy;	
		
		$this->setStyle(GUI_NAVIGATION_BUTTON_DEFAULT_STYLE);
		$this->setSubStyle(GUI_NAVIGATION_BUTTON_DEFAULT_SUBSTYLE);
		
		$this->text = new Label();
		$this->text->setValign("center");
		$this->text->setPosition($this->textXpos, 0.25, 1);
		$this->text->setStyle(GUI_NAVIGATION_BUTTON_TEXT_DEFAULT_STYLE);
		
		$this->icon = new Icon($this->sizeY-$this->iconSizeMinimizer);
		$this->icon->setValign("center");
		$this->icon->setPosition(1, 0, 1);
	}
	
	/**
	 * Set the button selected
	 */
	function setSelected() 
	{
		$this->setSubStyle(GUI_NAVIGATION_BUTTON_SELECTED_DEFAULT_SUBSTYLE);
		$this->text->setStyle(GUI_NAVIGATION_BUTTON_SELECTED_TEXT_DEFAULT_STYLE);	
	}
	
	protected function outputPostFilter ()
	{
		// Calculus and stuff
		$newPos = Manialink::getAlignedPos ($this, "left", "center");
		$this->text->setSizeX($this->sizeX - $this->textXpos - $this->textSizeMinimizer);
		$this->icon->setSize($this->sizeY-$this->iconSizeMinimizer, $this->sizeY-$this->iconSizeMinimizer);
		if($this->forceLinks)
		{
			$this->text->addLink($this);
			$this->icon->addLink($this);
		}
		
		// Drawing
		Manialink::beginFrame($newPos["x"], $newPos["y"], $this->posZ+1, $this->output);
			$this->text->draw($this->output);
			$this->icon->draw($this->output);
		Manialink::endFrame($this->output);
	}
}

?>
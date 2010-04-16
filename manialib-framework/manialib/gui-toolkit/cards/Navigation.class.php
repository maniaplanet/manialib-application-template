<?php
/**
 * @author Maxime Raoust
 * @package Manialib
 */

require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'cards/NavigationButton.class.php' );

/**
 * Navigation menu
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
		
		$this->titleBg = new Quad ($this->sizeX-1, 7);
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
	 * Adds a navigation button to the menu
	 */
	function addItem() 
	{
		$item = new NavigationButton($this->sizeX-1);
		$this->items[] = $item;
	}
	
	/**
	 * Return a reference of the last added item
	 * @return NavigationButton Reference on a NavigationButton object
	 */
	function lastItem() 
	{
		return end($this->items);
	}
	
	/**
	 * Adds a vertical gap before the next item
	 * @param float
	 */
	function addGap($gap = 3) 
	{
		$item = new Spacer(1, $gap);
		$this->items[] = $item;
	}
	
	/**
	 * Hides the quit/back button
	 */
	function hideQuitButton() 
	{
		$this->showQuitButton = false;
	}
	
	protected function preFilter () 
	{
		Manialink::beginFrame(-64, 48, 1);
	}
	
	protected function postFilter () 
	{
		// Frame was created in preFilter
		// Manialink::beginFrame()
		{
			Manialink::beginFrame($this->posX+0.5, $this->posY-0.5, $this->posZ+1);
			{
				$this->titleBg->save();
				$this->title->save();
				$this->subTitle->save();
				$this->logo->save();
				
				$layout = new ColumnLayout($this->sizeX-1, $this->sizeY-10);
				$layout->setMarginHeight(1);
				Manialink::beginFrame(0, -10, 0, $layout);
				{
					foreach($this->items as $item) 
					{
						$item->save();
					}
					Manialink::endFrame();
				}
				if($this->showQuitButton) 
				{
					$this->quitButton->setSizeX($this->sizeX-1);
					$this->quitButton->setPosition(0, -$this->sizeY+$this->quitButton->getSizeY()+2);
					$this->quitButton->save();
				}
			}
			Manialink::endFrame();
		}	
		Manialink::endFrame();
	}	
}

?>
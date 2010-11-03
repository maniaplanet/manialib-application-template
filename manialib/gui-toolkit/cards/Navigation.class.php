<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * @ignore
 */
require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'cards/NavigationButton.class.php' );

/**
 * Navigation menu
 * Looks like the navigation menu on the left in the game menus
 * @package ManiaLib
 * @subpackage GUIToolkit_Cards
 */
class Navigation extends Quad
{
	const BUTTONS_TOP = true;
	const BUTTONS_BOTTOM = false;
	
	/**
	 * @var Label
	 */
	public $title;
	/**
	 * @var Label
	 */
	public $subTitle;
	/**
	 * @var Quad
	 */
	public $titleBg;
	/**
	 * @var Quad
	 */
	public $logo;
	/**
	 * @var NavigationButton
	 */
	public $quitButton;
	/**
	 * @var NavigationButton
	 */
	public $lastItem;
	
	/**#@+
	 * @ignore
	 */
	protected $showQuitButton = true;
	protected $items = array();
	protected $bottomItems = array();
	protected $marginHeight = 1;
	protected $yIndex = -10;
	protected $sizeX = 30;
	protected $sizeY = 96;
	/**#@-*/

	function __construct () 
	{	
		$this->setStyle(GuiDefaultStyles::Navigation_Style);
		$this->setSubStyle(GuiDefaultStyles::Navigation_Substyle);
		
		$this->titleBg = new Quad ($this->sizeX-1, 7);
		$this->titleBg->setStyle(GuiDefaultStyles::Navigation_TitleBg_Style);
		$this->titleBg->setSubStyle(GuiDefaultStyles::Navigation_TitleBg_Substyle);
		
		$this->title = new Label ($this->sizeX-2.5);
		$this->title->setPosition (1.5, -0.75, 2);
		$this->title->setStyle(GuiDefaultStyles::Navigation_Title_Style);
		
		$this->subTitle = new Label ($this->sizeX-4);
		$this->subTitle->setPosition (1.5, -4, 3);
		$this->subTitle->setStyle(GuiDefaultStyles::Navigation_Subtitle_Style);
		
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
	function addItem($topItem = self::BUTTONS_TOP) 
	{
		$item = new NavigationButton($this->sizeX-1);
		if($topItem)
			$this->items[] = $item;
		else
			$this->bottomItems[] = $item;
		
		$this->lastItem = $item;
	}
	
	/**
	 * Return a reference of the last added item
	 * @deprecated use self::$lastItem instead (better performance)
	 * @return NavigationButton Reference on a NavigationButton object
	 */
	function lastItem() 
	{
		return $this->lastItem;
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
	
	/**
	 * @ignore
	 */
	protected function preFilter () 
	{
		Manialink::beginFrame(-64, 48, 1);
	}
	
	/**
	 * @ignore
	 */
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
				
				if($this->items)
				{
					$layout = new ColumnLayout($this->sizeX-1, $this->sizeY-10);
					$layout->setMarginHeight(1);
					Manialink::beginFrame(0, -10, 0, null, $layout);
					{
						foreach($this->items as $item) 
						{
							$item->save();
						}
						Manialink::endFrame();
					}
				}
				
				if($this->bottomItems)
				{
					$this->bottomItems = array_reverse($this->bottomItems);
					
					$layout = new ColumnLayout($this->sizeX-1, $this->sizeY-10);
					$layout->setDirection(ColumnLayout::DIRECTION_UP);
					$layout->setMarginHeight(1);
					Manialink::beginFrame(0, -$this->sizeY+$this->quitButton->getSizeY()+2, 0, null, $layout);
					{
						foreach($this->bottomItems as $item) 
						{
							$item->save();
						}
						Manialink::endFrame();
					}
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
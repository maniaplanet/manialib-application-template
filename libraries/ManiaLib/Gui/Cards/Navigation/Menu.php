<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */


/**
 * Navigation menu
 * Looks like the navigation menu on the left in the game menus
 * @package ManiaLib
 * @subpackage GUIToolkit_Cards
 */
class ManiaLib_Gui_Cards_Navigation_Menu extends ManiaLib_Gui_Elements_Quad
{
	const BUTTONS_TOP = true;
	const BUTTONS_BOTTOM = false;
	
	/**
	 * @var ManiaLib_Gui_Elements_Label
	 */
	public $title;
	/**
	 * @var ManiaLib_Gui_Elements_Label
	 */
	public $subTitle;
	/**
	 * @var ManiaLib_Gui_Elements_Quad
	 */
	public $titleBg;
	/**
	 * @var ManiaLib_Gui_Elements_Quad
	 */
	public $logo;
	/**
	 * @var ManiaLib_Gui_Cards_Navigation_Button
	 */
	public $quitButton;
	/**
	 * @var ManiaLib_Gui_Cards_Navigation_Button
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
		$this->setStyle(ManiaLib_Gui_DefaultStyles::Navigation_Style);
		$this->setSubStyle(ManiaLib_Gui_DefaultStyles::Navigation_Substyle);
		
		$this->titleBg = new ManiaLib_Gui_Elements_Quad ($this->sizeX-1, 7);
		$this->titleBg->setStyle(ManiaLib_Gui_DefaultStyles::Navigation_TitleBg_Style);
		$this->titleBg->setSubStyle(ManiaLib_Gui_DefaultStyles::Navigation_TitleBg_Substyle);
		
		$this->title = new ManiaLib_Gui_Elements_Label ($this->sizeX-2.5);
		$this->title->setPosition (1.5, -0.75, 2);
		$this->title->setStyle(ManiaLib_Gui_DefaultStyles::Navigation_Title_Style);
		
		$this->subTitle = new ManiaLib_Gui_Elements_Label ($this->sizeX-4);
		$this->subTitle->setPosition (1.5, -4, 3);
		$this->subTitle->setStyle(ManiaLib_Gui_DefaultStyles::Navigation_Subtitle_Style);
		
		$this->quitButton = new ManiaLib_Gui_Cards_Navigation_Button();
		$this->quitButton->text->setText("Back");
		$this->quitButton->icon->setSubStyle("Back");
		
		$this->logo = new ManiaLib_Gui_Elements_Icon(6);
		$this->logo->setPosition (22.5, -0.5, 2);
		$this->logo->setSubStyle(null);
	}
	
	/**
	 * Adds a navigation button to the menu
	 */
	function addItem($topItem = self::BUTTONS_TOP) 
	{
		$item = new ManiaLib_Gui_Cards_Navigation_Button($this->sizeX-1);
		if($topItem)
			$this->items[] = $item;
		else
			$this->bottomItems[] = $item;
		
		$this->lastItem = $item;
	}
	
	/**
	 * Return a reference of the last added item
	 * @deprecated use self::$lastItem instead (better performance)
	 * @return ManiaLib_Gui_Cards_Navigation_Button (ref)
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
		$item = new ManiaLib_Gui_Elements_Spacer(1, $gap);
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
		ManiaLib_Gui_Manialink::beginFrame(-64, 48, 1);
	}
	
	/**
	 * @ignore
	 */
	protected function postFilter () 
	{
		// Frame was created in preFilter
		// ManiaLib_Gui_Manialink::beginFrame()
		{
			ManiaLib_Gui_Manialink::beginFrame($this->posX+0.5, $this->posY-0.5, $this->posZ+1);
			{
				$this->titleBg->save();
				$this->title->save();
				$this->subTitle->save();
				$this->logo->save();
				
				if($this->items)
				{
					$layout = new ManiaLib_Gui_Layouts_Column($this->sizeX-1, $this->sizeY-10);
					$layout->setMarginHeight(1);
					ManiaLib_Gui_Manialink::beginFrame(0, -10, 0, null, $layout);
					{
						foreach($this->items as $item) 
						{
							$item->save();
						}
						ManiaLib_Gui_Manialink::endFrame();
					}
				}
				
				if($this->bottomItems)
				{
					$this->bottomItems = array_reverse($this->bottomItems);
					
					$layout = new ManiaLib_Gui_Layouts_Column($this->sizeX-1, $this->sizeY-10);
					$layout->setDirection(ManiaLib_Gui_Layouts_Column::DIRECTION_UP);
					$layout->setMarginHeight(1);
					ManiaLib_Gui_Manialink::beginFrame(0, -$this->sizeY+$this->quitButton->getSizeY()+2, 0, null, $layout);
					{
						foreach($this->bottomItems as $item) 
						{
							$item->save();
						}
						ManiaLib_Gui_Manialink::endFrame();
					}
				}
				
				if($this->showQuitButton) 
				{
					$this->quitButton->setSizeX($this->sizeX-1);
					$this->quitButton->setPosition(0, -$this->sizeY+$this->quitButton->getSizeY()+2);
					$this->quitButton->save();
				}
			}
			ManiaLib_Gui_Manialink::endFrame();
		}	
		ManiaLib_Gui_Manialink::endFrame();
	}	
}

?>
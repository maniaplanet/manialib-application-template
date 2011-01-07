<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\Gui\Cards\Navigation;

/**
 * Navigation menu
 * Looks like the navigation menu on the left in the game menus
 */
class Menu extends \ManiaLib\Gui\Elements\Quad
{
	const BUTTONS_TOP = true;
	const BUTTONS_BOTTOM = false;
	
	/**
	 * @var \ManiaLib\Gui\Elements\Label
	 */
	public $title;
	/**
	 * @var \ManiaLib\Gui\Elements\Label
	 */
	public $subTitle;
	/**
	 * @var \ManiaLib\Gui\Elements\Quad
	 */
	public $titleBg;
	/**
	 * @var \ManiaLib\Gui\Elements\Quad
	 */
	public $logo;
	/**
	 * @var \ManiaLib\Gui\Cards\Navigation\Button
	 */
	public $quitButton;
	/**
	 * @var \ManiaLib\Gui\Cards\Navigation\Button
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
		$this->setStyle(\ManiaLib\Gui\DefaultStyles::Navigation_Style);
		$this->setSubStyle(\ManiaLib\Gui\DefaultStyles::Navigation_Substyle);
		
		$this->titleBg = new \ManiaLib\Gui\Elements\Quad ($this->sizeX-1, 7);
		$this->titleBg->setStyle(\ManiaLib\Gui\DefaultStyles::Navigation_TitleBg_Style);
		$this->titleBg->setSubStyle(\ManiaLib\Gui\DefaultStyles::Navigation_TitleBg_Substyle);
		
		$this->title = new \ManiaLib\Gui\Elements\Label ($this->sizeX-2.5);
		$this->title->setPosition (1.5, -0.75, 2);
		$this->title->setStyle(\ManiaLib\Gui\DefaultStyles::Navigation_Title_Style);
		
		$this->subTitle = new \ManiaLib\Gui\Elements\Label ($this->sizeX-4);
		$this->subTitle->setPosition (1.5, -4, 3);
		$this->subTitle->setStyle(\ManiaLib\Gui\DefaultStyles::Navigation_Subtitle_Style);
		
		$this->quitButton = new \ManiaLib\Gui\Cards\Navigation\Button();
		$this->quitButton->text->setText("Back");
		$this->quitButton->icon->setSubStyle("Back");
		
		$this->logo = new \ManiaLib\Gui\Elements\Icon(6);
		$this->logo->setPosition (22.5, -0.5, 2);
		$this->logo->setSubStyle(null);
	}
	
	/**
	 * Adds a navigation button to the menu
	 */
	function addItem($topItem = self::BUTTONS_TOP) 
	{
		$item = new \ManiaLib\Gui\Cards\Navigation\Button($this->sizeX-1);
		if($topItem)
			$this->items[] = $item;
		else
			$this->bottomItems[] = $item;
		
		$this->lastItem = $item;
	}
	
	/**
	 * Return a reference of the last added item
	 * @deprecated use self::$lastItem instead (better performance)
	 * @return \ManiaLib\Gui\Cards\Navigation\Button (ref)
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
		$item = new \ManiaLib\Gui\Elements\Spacer(1, $gap);
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
		\ManiaLib\Gui\Manialink::beginFrame(-64, 48, 1);
	}
	
	/**
	 * @ignore
	 */
	protected function postFilter () 
	{
		// Frame was created in preFilter
		// \ManiaLib\Gui\Manialink::beginFrame()
		{
			\ManiaLib\Gui\Manialink::beginFrame($this->posX+0.5, $this->posY-0.5, $this->posZ+1);
			{
				$this->titleBg->save();
				$this->title->save();
				$this->subTitle->save();
				$this->logo->save();
				
				if($this->items)
				{
					$layout = new \ManiaLib\Gui\Layouts\Column($this->sizeX-1, $this->sizeY-10);
					$layout->setMarginHeight(1);
					\ManiaLib\Gui\Manialink::beginFrame(0, -10, 0, null, $layout);
					{
						foreach($this->items as $item) 
						{
							$item->save();
						}
						\ManiaLib\Gui\Manialink::endFrame();
					}
				}
				
				if($this->bottomItems)
				{
					$this->bottomItems = array_reverse($this->bottomItems);
					
					$layout = new \ManiaLib\Gui\Layouts\Column($this->sizeX-1, $this->sizeY-10);
					$layout->setDirection(\ManiaLib\Gui\Layouts\Column::DIRECTION_UP);
					$layout->setMarginHeight(1);
					\ManiaLib\Gui\Manialink::beginFrame(0, -$this->sizeY+$this->quitButton->getSizeY()+2, 0, null, $layout);
					{
						foreach($this->bottomItems as $item) 
						{
							$item->save();
						}
						\ManiaLib\Gui\Manialink::endFrame();
					}
				}
				
				if($this->showQuitButton) 
				{
					$this->quitButton->setSizeX($this->sizeX-1);
					$this->quitButton->setPosition(0, -$this->sizeY+$this->quitButton->getSizeY()+2);
					$this->quitButton->save();
				}
			}
			\ManiaLib\Gui\Manialink::endFrame();
		}	
		\ManiaLib\Gui\Manialink::endFrame();
	}	
}

?>
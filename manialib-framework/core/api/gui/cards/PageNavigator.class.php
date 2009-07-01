<?php
/**
 * Manialink GUI API
 * @author Maxime Raoust
 */

/**
 * Page Navigator
 * @package gui_api
 */
class PageNavigator
{
	public $arrowNext;
	public $arrowPrev;
	public $arrowFastNext;
	public $arrowFastPrev;
	public $arrowLast;
	public $arrowFirst;
	public $text;

	public $arrowNoneStyle = GUI_PAGE_NAVIGATOR_ARROW_NONE_SUBSTYLE;
	public $arrowNextStyle = GUI_PAGE_NAVIGATOR_ARROW_NEXT_SUBSTYLE;
	public $arrowPrevStyle = GUI_PAGE_NAVIGATOR_ARROW_PREV_SUBSTYLE;
	public $arrowFastNextStyle = GUI_PAGE_NAVIGATOR_ARROW_FAST_NEXT_SUBSTYLE;
	public $arrowFastPrevStyle = GUI_PAGE_NAVIGATOR_ARROW_FAST_PREV_SUBSTYLE;
	public $arrowFirstStyle = GUI_PAGE_NAVIGATOR_ARROW_FIRST_SUBSTYLE;
	public $arrowLastStyle = GUI_PAGE_NAVIGATOR_ARROW_LAST_SUBSTYLE;

	protected $showLast;
	protected $showFastNext;
	protected $showText;
	protected $pageNumber;
	protected $currentPage;
	protected $posX;
	protected $posY;
	protected $posZ;

	function __construct($iconSize = 5)
	{
		$this->arrowNext = new Icon64($iconSize);
		$this->arrowPrev = new Icon64($iconSize);
		$this->arrowFastNext = new Icon64($iconSize);
		$this->arrowFastPrev = new Icon64($iconSize);
		$this->arrowLast = new Icon64($iconSize);
		$this->arrowFirst = new Icon64($iconSize);
		$this->text = new Label(5);
		
		$this->showLast = false;
		$this->showFastNext = false;
		$this->showText = true;
		$this->currentPage = 1;
		$this->pageNumber = 2;
		
		$this->arrowNext->setSubStyle($this->arrowNoneStyle);
		$this->arrowPrev->setSubStyle($this->arrowNoneStyle);
		$this->arrowFastNext->setSubStyle($this->arrowNoneStyle);
		$this->arrowFastPrev->setSubStyle($this->arrowNoneStyle);
		$this->arrowLast->setSubStyle($this->arrowNoneStyle);
		$this->arrowFirst->setSubStyle($this->arrowNoneStyle);
	}
	
	/**
	 * Sets the size of the navigation icons
	 */
	function setSize($iconSize = 5)
	{
		$this->arrowNext->setSize($iconSize, $iconSize);
		$this->arrowPrev->setSize($iconSize, $iconSize);
		$this->arrowFastNext->setSize($iconSize, $iconSize);
		$this->arrowFastPrev->setSize($iconSize, $iconSize);
		$this->arrowLast->setSize($iconSize, $iconSize);
		$this->arrowFirst->setSize($iconSize, $iconSize);
	}
	
	/**
	 * Sets the position of the center of the PageNavigator
	 */
	function setPosition($x = 0, $y = 0, $z = 0)
	{
		$this->posX = $x;
		$this->posY = $y;
		$this->posZ = $z;
	}
	
	/**
	 * Sets the page number
	 */
	function setPageNumber($pageNumber)
	{
		$this->pageNumber = $pageNumber;
	}
	
	/**
	 * Sets the current page
	 */
	function setCurrentPage($currentPage)
	{
		$this->currentPage = $currentPage;
	}
	
	/**
	 * Shows or hides the "go to first/last" navigation icons
	 */
	function showLast($show = true)
	{
		$this->showLast = $show;
	}
	
	/**
	 * Returns whether the "go to first/last" navigation icons are shown 
	 */
	function isLastShown()
	{
		return $this->showLast;
	}
	
	/**
	 * Shows or hides the "fast prev/next" navigation icons
	 */
	function showFastNext($show = true)
	{
		$this->showFastNext = $show;
	}
	
	/**
	 * Returns whether the "fast prev/next" navigation icons are shown 
	 */
	function isFastNextShown()
	{
		return $this->showFastNext;
	}
	
	/**
	 * Shows or hides the text. Note that if the current page or the page number
	 * isn't declared, the text won't be shown
	 */
	function showText($show = true)
	{
		$this->showText = $show;
	}
	
	/**
	 * Returns whether the text is shown
	 */
	function isTextShown()
	{
		return $this->showText;
	}
	
	/**
	 * Saves the PageNavigator in the GUI objects stack
	 */
	function save()
	{
		// Show / hide text
		if(!$this->currentPage || !$this->pageNumber)
		{
			$this->hideText();
		}
		
		// Auto show fast next / last
		if($this->arrowFirst->hasLink() || $this->arrowLast->hasLink() )
		{
			$this->showLast();
		}
		if($this->arrowFastNext->hasLink() || $this->arrowFastPrev->hasLink() )
		{
			$this->showFastNext();
		}
		
		// Arrow styles
		if($this->arrowNext->hasLink()) $this->arrowNext->setSubStyle($this->arrowNextStyle);
		if($this->arrowPrev->hasLink()) $this->arrowPrev->setSubStyle($this->arrowPrevStyle);
		if($this->arrowFastNext->hasLink()) $this->arrowFastNext->setSubStyle($this->arrowFastNextStyle);
		if($this->arrowFastPrev->hasLink()) $this->arrowFastPrev->setSubStyle($this->arrowFastPrevStyle);
		if($this->arrowLast->hasLink()) $this->arrowLast->setSubStyle($this->arrowLastStyle);
		if($this->arrowFirst->hasLink()) $this->arrowFirst->setSubStyle($this->arrowFirstStyle);

		// Text
		$this->text->setStyle("TextStaticSmall");
		$this->text->setText($this->currentPage . "/" . $this->pageNumber);

		// Positioning in relation to the center of the containing frame
		$this->text->setAlign("center", "center");
		$this->text->setPositionZ(1);

		$this->arrowNext->setValign("center");
		$this->arrowFastNext->setValign("center");
		$this->arrowLast->setValign("center");

		$this->arrowNext->setPosition(($this->text->getSizeX() / 2) + 1, 0, 1);
		$this->arrowFastNext->setPosition($this->arrowNext->getPosX() + $this->arrowNext->getSizeX(), 0, 1);
		$this->arrowLast->setPosition(
			$this->arrowNext->getPosX() + 
			(int)$this->showFastNext*$this->arrowFastNext->getSizeX() + 
			$this->arrowNext->getSizeX(), 
			0, 1);

		$this->arrowPrev->setAlign("right", "center");
		$this->arrowFastPrev->setAlign("right", "center");
		$this->arrowFirst->setAlign("right", "center");

		$this->arrowPrev->setPosition(-($this->text->getSizeX()/2) - 1, 0, 1);
		$this->arrowFastPrev->setPosition($this->arrowPrev->getPosX() - $this->arrowPrev->getSizeX(), 0, 1);
		$this->arrowFirst->setPosition(
			$this->arrowPrev->getPosX() -
			(int)$this->showFastNext*$this->arrowFastPrev->getSizeX() - 
			$this->arrowPrev->getSizeX(),
			0, 1);

		// Save the gui
		Manialink::beginFrame($this->posX, $this->posY, $this->posZ);

			if ($this->showText)
			{
				$this->text->save();
			}
			
			$this->arrowNext->save();
			$this->arrowPrev->save();
			
			if ($this->showLast)
			{
				$this->arrowFirst->save();
				$this->arrowLast->save();
			}
			
			if ($this->showFastNext)
			{
				$this->arrowFastNext->save();
				$this->arrowFastPrev->save();
			}

		Manialink::endFrame();
	}
}
?>

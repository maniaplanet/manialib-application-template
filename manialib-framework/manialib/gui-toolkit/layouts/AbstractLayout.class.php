<?php
/**
 * @package Manialib
 * @author Maxime Raoust
 */

// TODO Create a parent class of GuiElement that only defines size, position and scale and use this class as parent of AbstractLayout

/**
 * Abstract class used for building layouts
 * @package Manialib
 */
abstract class AbstractLayout
{
	public $xIndex = 0;
	public $yIndex = 0;
	public $zIndex = 0;
	protected $sizeX;
	protected $sizeY;
	protected $marginWidth;
	protected $marginHeight;
	protected $borderWidth;
	protected $borderHeight;
	
	/**
	 * Default constructor is used to set the size of the layout, just like
	 * GuiElement
	 * @param float Layout's width
	 * @param float Layout's height
	 */
	function __construct($sizeX=20, $sizeY=20)
	{
		$this->sizeX = $sizeX;
		$this->sizeY = $sizeY;
	}
	
	/**
	 * Returns the width of the layout
	 * @return float
	 */	
	function getSizeX()
	{
		return $this->sizeX;
	}
	
	/**
	 * Returns the height of the layout
	 * @return float
	 */
	function getSizeY()
	{
		return $this->sizeY;
	}
	
	/**
	 * Sets the horizontal margin between two elements of the layout
	 * @param float
	 */
	function setMarginWidth($marginWidth)
	{
		$this->marginWidth = $marginWidth;
	}
	
	/**
	 * Sets the vertical margin between two elements of the layout
	 * @param float
	 */
	function setMarginHeight($marginHeight)
	{
		$this->marginHeight = $marginHeight;
	}
	
	/**
	 * Sets the margin between two elements of the layout
	 * @param Horizontal margin
	 * @param Vertical margin
	 */
	function setMargin($marginWidth = 0, $marginHeight = 0)
	{
		$this->marginWidth = $marginWidth;
		$this->marginHeight = $marginHeight;
	}
	
	/**
	 * Returns the horizontal margin between two elements of the layout
	 * @return float
	 */
	function getMarginWidth()
	{
		return $this->marginWidth;
	}
	
	/**
	 * Returns the vertical margin between two elements of the layout
	 * @return float
	 */
	function getMarginHeight()
	{
		return $this->marginHeight;
	}
	
	/**
	 * Sets the width between the layout outer border and its content
	 * @param float
	 */
	function setBorderWidth($borderWidth)
	{
		$this->borderWidth = $borderWidth;
		$this->xIndex = $borderWidth;
	}
	
	/**
	 * Sets the height between the layout outer border and its content
	 * @param float
	 */
	function setBorderHeight($borderHeight)
	{
		$this->borderHeight = $borderHeight;
		$this->yIndex = - $borderHeight;
	}
	
	/**
	 * Sets the gap between the layout outer border and its content
	 * @param Border width
	 * @param Border height
	 */
	function setBorder($borderWidth = 0, $borderHeight = 0)
	{
		$this->borderWidth = $borderWidth;
		$this->xIndex = $borderWidth;
		$this->borderHeight = $borderHeight;
		$this->yIndex = - $borderHeight;
	}
	
	/**
	 * Returns the width between the layout outer border and its content
	 * @return float
	 */
	function getBorderWidth()
	{
		return $this->borderWidth;
	}
	
	/**
	 * Returns the height between the layout outer border and its content
	 * @return float
	 */
	function getBorderHeight()
	{
		return $this->borderHeight;
	}
	
	/**
	 * Override this method to perform an action before rendering an item.
	 * Typical use: look for overflow
	 */
	function preFilter(GuiElement $item) 
	{	
	}

	/**
	 * Override this method to perform an action after rendering an an item.
	 * Typical use: update x,y,z indexes for the next item 
	 */
	function postFilter(GuiElement $item)
	{
	}
}

?>
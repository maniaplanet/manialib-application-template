<?php
/**
 * Manialink GUI API
 * @author Maxime Raoust
 */

/**
 * Abstract class for defining layout managers
 * @package gui_api
 */
abstract class AbstractLayout
{
	public $xIndex;
	public $yIndex;
	public $zIndex;
	protected $sizeX;
	protected $sizeY;
	protected $marginWidth;
	protected $marginHeight;
	protected $borderWidth;
	protected $borderHeight;

	function __construct($sx=20, $sy=20)
	{
		$this->sizeX = $sx;
		$this->sizeY = $sy;
		$this->xIndex = 0;
		$this->yIndex = 0;
		$this->zIndex = 0;
	}
	
	function getSizeX()
	{
		return $this->sizeX;
	}

	function getSizeY()
	{
		return $this->sizeY;
	}

	public function setMarginWidth($marginWidth)
	{
		$this->marginWidth = $marginWidth;
	}

	public function setMarginHeight($marginHeight)
	{
		$this->marginHeight = $marginHeight;
	}

	public function setMargin($marginWidth = 0, $marginHeight = 0)
	{
		$this->marginWidth = $marginWidth;
		$this->marginHeight = $marginHeight;
	}

	public function getMarginWidth()
	{
		return $this->marginWidth;
	}

	public function getMarginHeight()
	{
		return $this->marginHeight;
	}

	public function setBorderWidth($borderWidth)
	{
		$this->borderWidth = $borderWidth;
		$this->xIndex = $borderWidth;
	}

	public function setBorderHeight($borderHeight)
	{
		$this->borderHeight = $borderHeight;
		$this->yIndex = - $borderHeight;
	}

	public function setBorder($borderWidth = 0, $borderHeight = 0)
	{
		$this->borderWidth = $borderWidth;
		$this->xIndex = $borderWidth;
		$this->borderHeight = $borderHeight;
		$this->yIndex = - $borderHeight;
	}

	public function getBorderWidth()
	{
		return $this->borderWidth;
	}

	public function getBorderHeight()
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
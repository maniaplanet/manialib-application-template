<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @see         http://code.google.com/p/manialib/
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\Gui;

abstract class Component extends ComponentBase
{

	protected $sizeX;
	protected $sizeY;
	protected $valign = null;
	protected $halign = null;
	protected $scriptEvents;

	/**
	 * Sets the vertical alignment of the element.
	 * @param string Vertical alignment can be either "top", "center" or
	 * "bottom"
	 */
	function setValign($valign)
	{
		$old = $this->valign;
		$this->valign = $valign;
		$this->onAlign($this->halign, $old);
	}

	/**
	 * Sets the horizontal alignment of the element
	 * @param string Horizontal alignement can be eithe "left", "center" or
	 * "right"
	 */
	function setHalign($halign)
	{
		$old = $this->halign;
		$this->halign = $halign;
		$this->onAlign($old, $this->valign);
	}

	/**
	 * Sets the alignment of the element
	 * @param string Horizontal alignement can be eithe "left", "center" or
	 * "right"
	 * @param string Vertical alignment can be either "top", "center" or
	 * "bottom"
	 */
	function setAlign($halign = null, $valign = null)
	{
		$oldHalign = $this->halign;
		$oldValign = $this->valign;
		$this->valign = $valign;
		$this->halign = $halign;
		$this->onAlign($oldHalign, $oldValign);
	}

	/**
	 * Sets the width of the element
	 * @param float
	 */
	function setSizeX($sizeX)
	{
		$oldX = $this->sizeX;
		$this->sizeX = $sizeX;
		$this->onResize($oldX, $this->sizeY);
	}

	/**
	 * Sets the height of the element
	 * @param float
	 */
	function setSizeY($sizeY)
	{
		$oldY = $this->sizeY;
		$this->sizeY = $sizeY;
		$this->onResize($this->sizeX, $oldY);
	}

	/**
	 * Sets the size of the element
	 * @param float
	 * @param float
	 */
	function setSize()
	{
		$oldX = $this->sizeX;
		$oldY = $this->sizeY;

		$args = func_get_args();

		if(!empty($args)) $this->sizeX = array_shift($args);

		if(!empty($args)) $this->sizeY = array_shift($args);

		$this->onResize($oldX, $oldY);
	}

	/**
	 * Sets additional ManiaScript events to be generated for this element.
	 * @param string
	 */
	function setScriptEvents($scriptEvent=true)
	{
		$this->scriptEvents = $scriptEvent;
	}

	/**
	 * Returns the width of the element
	 * @return float
	 */
	function getSizeX()
	{
		return $this->sizeX;
	}

	/**
	 * Returns the height of the element
	 * @return float
	 */
	function getSizeY()
	{
		return $this->sizeY;
	}

	/**
	 * Returns the width of the element with the
	 * applied scaling factor.
	 * @return float
	 */
	function getRealSizeX()
	{
		return $this->sizeX * ($this->scale ? $this->scale : 1);
	}

	/**
	 * Returns the height of the element with the
	 * applied scaling factor.
	 * @return float
	 */
	function getRealSizeY()
	{
		return $this->sizeY * ($this->scale ? $this->scale : 1);
	}

	/**
	 * Return the x-coordinate for the left border of the Component.
	 * @return float
	 */
	function getBorderLeft()
	{
		return $this->getPosX();
	}

	/**
	 * Return the x-coordinate for the right border of the Component.
	 * @return float
	 */
	function getBorderRight()
	{
		return $this->getPosX() + $this->getRealSizeX();
	}

	/**
	 * Return y-coordinate for the top border of the Component.
	 * @return float
	 */
	function getBorderTop()
	{
		return $this->getPosY();
	}

	/**
	 * Return y-coordinate for the bottom border of the Component.
	 * @return float
	 */
	function getBorderBottom()
	{
		return $this->getPosY() + $this->getRealSizeY();
	}

	/**
	 * Returns the horizontal alignment of the element
	 * @return string
	 */
	function getHalign()
	{
		return $this->halign;
	}

	/**
	 * Returns the vertical alignment of the element
	 * @return string
	 */
	function getValign()
	{
		return $this->valign;
	}

	function getScriptEvents()
	{
		return $this->scriptEvents;
	}

	/**
	 * Overridable callback on component change
	 */
	protected function onResize($oldX, $oldY)
	{
		
	}

	/**
	 * Overridable callback on component change
	 */
	protected function onAlign($oldHalign, $oldValign)
	{
		
	}

}

?>
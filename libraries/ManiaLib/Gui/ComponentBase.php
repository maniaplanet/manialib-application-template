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

abstract class ComponentBase
{

	protected $id;
	protected $visible = true;
	protected $posX = 0;
	protected $posY = 0;
	protected $posZ = 0;
	protected $scale;

	/**
	 * @var \DOMNode
	 */
	protected $parentNode = false;

	/**
	 * @var Layouts\AbstractLayout
	 */
	protected $parentLayout = false;

	/**
	 * Set the id of the element
	 * @param int
	 */
	function setId($id)
	{
		$this->id = $id;
	}

	/**
	 * Sets the X position of the element
	 * @param float
	 */
	function setPositionX($posX)
	{
		$oldX = $this->posX;
		$this->posX = $posX;
		$this->onMove($oldX, $this->posY, $this->posZ);
	}

	/**
	 * Sets the Y position of the element
	 * @param float
	 */
	function setPositionY($posY)
	{
		$oldY = $this->posY;
		$this->posY = $posY;
		$this->onMove($this->posX, $oldY, $this->posZ);
	}

	/**
	 * Sets the Z position of the element
	 * @param float
	 */
	function setPositionZ($posZ)
	{
		$oldZ = $this->posZ;
		$this->posZ = $posZ;
		$this->onMove($this->posX, $this->posY, $oldZ);
	}

	/**
	 * Sets the X position of the element
	 * @param float
	 */
	function setPosX($posX)
	{
		$oldX = $this->posX;
		$this->posX = $posX;
		$this->onMove($oldX, $this->posY, $this->posZ);
	}

	/**
	 * Sets the Y position of the element
	 * @param float
	 */
	function setPosY($posY)
	{
		$oldY = $this->posY;
		$this->posY = $posY;
		$this->onMove($this->posX, $oldY, $this->posZ);
	}

	/**
	 * Sets the Z position of the element
	 * @param float
	 */
	function setPosZ($posZ)
	{
		$oldZ = $this->posZ;
		$this->posZ = $posZ;
		$this->onMove($this->posX, $this->posY, $oldZ);
	}

	/**
	 * Increment position X
	 * @param float
	 */
	function incPosX($posX)
	{
		$oldX = $this->posX;
		$this->posX += $posX;
		$this->onMove($oldX, $this->posY, $this->posZ);
	}

	/**
	 * Increment position Y
	 * @param float
	 */
	function incPosY($posY)
	{
		$oldY = $this->posY;
		$this->posY += $posY;
		$this->onMove($this->posX, $oldY, $this->posZ);
	}

	/**
	 * Increment position Z
	 * @param float
	 */
	function incPosZ($posZ)
	{
		$oldZ = $this->posZ;
		$this->posZ += $posZ;
		$this->onMove($this->posX, $this->posY, $oldZ);
	}

	/**
	 * Sets the position of the element
	 * @param float
	 * @param float
	 * @param float
	 */
	function setPosition()
	{
		$oldX = $this->posX;
		$oldY = $this->posY;
		$oldZ = $this->posZ;

		$args = func_get_args();

		if(!empty($args)) $this->posX = array_shift($args);

		if(!empty($args)) $this->posY = array_shift($args);

		if(!empty($args)) $this->posZ = array_shift($args);

		$this->onMove($oldX, $oldY, $oldZ);
	}

	/**
	 * Sets the scale factor of the element. 1=original size, 2=double size, 0.5
	 * =half size
	 * @param float
	 */
	function setScale($scale)
	{
		$oldScale = $this->scale;
		$this->scale = $scale;
		$this->onScale($oldScale);
	}

	/**
	 * Sets the visibility of the Component.
	 * This is used by ManiaLive.
	 * @param bool $visible If set to false the Component (and subcomponents) is not rendered.
	 */
	function setVisibility($visible)
	{
		$this->visible = $visible;
	}

	function getId()
	{
		return $this->id;
	}

	/**
	 * Returns the X position of the element
	 * @return float
	 */
	function getPosX()
	{
		return $this->posX;
	}

	/**
	 * Returns the Y position of the element
	 * @return float
	 */
	function getPosY()
	{
		return $this->posY;
	}

	/**
	 * Returns the Z position of the element
	 * @return float
	 */
	function getPosZ()
	{
		return $this->posZ;
	}

	/**
	 * Returns the scale of the element
	 * @return float
	 */
	function getScale()
	{
		return $this->scale;
	}

	/**
	 * Is the Component rendered onto the screen or not?
	 * This is used by ManiaLive.
	 * @return bool
	 */
	function isVisible()
	{
		return $this->visible;
	}

	final function setParentNode(\DOMNode $node)
	{
		$this->parentNode = $node;
	}

	final function setParentLayout($layout)
	{
		$this->parentLayout = $layout;
	}

	/**
	 * @return \DOMNode
	 */
	final function getParentNode()
	{
		return $this->parentNode !== false ? $this->parentNode : end(Manialink::$parentNodes);
	}

	/**
	 * @return Layouts\AbstractLayout
	 */
	final function getParentLayout()
	{
		return $this->parentLayout !== false ? $this->parentLayout : end(Manialink::$parentLayouts);
	}

	/**
	 * Overridable callback on component change
	 */
	protected function onMove($oldX, $oldY, $oldZ)
	{
		
	}

	/**
	 * Overridable callback on component change
	 */
	protected function onScale($oldScale)
	{
		
	}

}

?>
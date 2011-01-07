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

namespace ManiaLib\Gui;

/**
 * Component
 */
abstract class Component
{
	/**#@+
	 * @ignore
	 */
	protected $posX = 0;
	protected $posY = 0;
	protected $posZ = 0;
	protected $sizeX;
	protected $sizeY;
	protected $scale;
	/**#@-*/
	
	/**
	 * Sets the X position of the element
	 * @param float
	 */
	function setPositionX($posX)
	{
		$this->posX = $posX;
	}
	
	/**
	 * Sets the Y position of the element
	 * @param float
	 */
	function setPositionY($posY)
	{
		$this->posY = $posY;
	}
	
	/**
	 * Sets the Z position of the element
	 * @param float
	 */
	function setPositionZ($posZ)
	{
		$this->posZ = $posZ;
	}
	
	/**
	 * Sets the X position of the element
	 * @param float
	 */
	function setPosX($posX)
	{
		$this->posX = $posX;
	}
	
	/**
	 * Sets the Y position of the element
	 * @param float
	 */
	function setPosY($posY)
	{
		$this->posY = $posY;
	}
	
	/**
	 * Sets the Z position of the element
	 * @param float
	 */
	function setPosZ($posZ)
	{
		$this->posZ = $posZ;
	}
	
	/**
	 * Increment position X
	 * @param float
	 */
	function incPosX($posX)
	{
		$this->posX += $posX;
	}
	
	/**
	 * Increment position Y
	 * @param float
	 */
	function incPosY($posY)
	{
		$this->posY += $posY;
	}
	
	/**
	 * Increment position Z
	 * @param float
	 */
	function incPosZ($posZ)
	{
		$this->posZ += $posZ;
	}
	
	/**
	 * Sets the position of the element
	 * @param float
	 * @param float
	 * @param float
	 */
	function setPosition($posX = 0, $posY = 0, $posZ = 0)
	{
		$this->posX = $posX;
		$this->posY = $posY;
		$this->posZ = $posZ;
	}
	
	/**
	 * Sets the width of the element
	 * @param float
	 */
	function setSizeX($sizeX)
	{
		$this->sizeX = $sizeX;
	}
	
	/**
	 * Sets the height of the element
	 * @param float
	 */
	function setSizeY($sizeY)
	{
		$this->sizeY = $sizeY;
	}
	
	/**
	 * Sets the size of the element
	 * @param float
	 * @param float
	 */
	function setSize($sizeX, $sizeY)
	{
		$this->sizeX = $sizeX;
		$this->sizeY = $sizeY;
	}
	
	/**
	 * Sets the scale factor of the element. 1=original size, 2=double size, 0.5
	 * =half size
	 * @param float
	 */
	function setScale($scale)
	{
		$this->scale = $scale;
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
	 * Returns the scale of the element
	 * @return float
	 */
	function getScale()
	{
		return $this->scale;
	}
}

?>
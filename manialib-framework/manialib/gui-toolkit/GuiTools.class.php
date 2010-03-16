<?php
/**
 * @package Manialib
 * @author Maxime Raoust
 */

/**
 * Static class that provides tools for Manialink handling
 * 
 * @package Manialib
 */
abstract class GuiTools
{
	/**
	 * Returns the X position of an element in relation to another element and
	 * according to their respective alignments
	 * 
	 * @param int X position of the parent element
	 * @param int Width of the parent element
	 * @param string Horizontal alignement of the parent element
	 * @param string Horizontal alignement of the element you want to place
	 * @return int Calculated X position of the element you want to place
	 */
	final public static function getAlignedPosX($posX, $sizeX, $halign, $newAlign)
	{
		if($halign == null)
		{
			$halign = 'left';
		}
		switch(array($halign, $newAlign))
		{
			case array('center', 'center') :
				$factor = 0;
				break;
				
			case array('center', 'left') :
				$factor = -0.5;
				break;
				
			case array('center', 'right') :
				$factor = 0.5;
				break;
				
			case array('left', 'center') :
				$factor = 0.5;
				break;
				
			case array('left', 'left') :
				$factor = 0;
				break;
				
			case array('left', 'right') :
				$factor = 1;
				break;
				
			case array('right', 'center') :
				$factor = -0.5;
				break;
				
			case array('right', 'left') :
				$factor = -1;
				break;
				
			case array('right', 'right') :
				$factor = 0;
				break;
				
		}
		return $posX + $factor * $sizeX;
	}

	/**
	 * Returns the Y position of an element in relation to another element and
	 * according to their respective alignments
	 * 
	 * @param int Y position of the parent element
	 * @param int Height of the parent element
	 * @param string Vertical alignement of the parent element
	 * @param string Vertical alignement of the element you want to place
	 * @return int Calculated Y position of the element you want to place
	 */
	final public static function getAlignedPosY($posY, $sizeY, $valign, $newAlign)
	{
		if($valign == 'top' || $valign == null)
		{
			$valign = 'right';
		}
		else
		{
			if($valign == 'bottom')
			{
				$valign = 'left';
			}
		}
		if($newAlign == 'top')
		{
			$newAlign = 'right';
		}
		else
		{
			if($newAlign == 'bottom')
			{
				$newAlign = 'left';
			}
		}
		return self::getAlignedPosX($posY, $sizeY, $valign, $newAlign);
	}

	/**
	 * Returns the position of an element in relation to another element and
	 * according to their respective alignments
	 * 
	 * @param GuiElement Parent element
	 * @param string Horizontal alignement of the element you want to place
	 * @param string Vertical alignement of the element you want to place
	 * @return array Calculated position of the element you want to place. The
	 * array contains 2 elements with "x" and "y" indexes
	 */
	final public static function getAlignedPos(GuiElement $object, $newHalign, $newValign)
	{
		$newPosX = self::getAlignedPosX(
			$object->getPosX(), 
			$object->getSizeX(), 
			$object->getHalign(), 
			$newHalign);
		$newPosY = self::getAlignedPosY(
			$object->getPosY(), 
			$object->getSizeY(), 
			$object->getValign(), 
			$newValign);
		return array('x' => $newPosX, 'y' => $newPosY);
	}
}

?>
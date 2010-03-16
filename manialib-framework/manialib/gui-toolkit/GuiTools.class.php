<?php
/**
 * Manialink GUI API
 * 
 * @author Maxime Raoust
 */

/**
 * Static class that provides tools for GuiElement
 * @package gui_api
 */
abstract class GuiTools
{
	/**
	 * Static method to get the X coordinate of a point in relation to another element
	 * @param Int $posX position of the parent element
	 * @param Int $sizeX Size of the parent element
	 * @param String $halign Halign of the parent element
	 * @param String $newAlign Halign of the to be positioned element
	 * @return Int
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
	 * Static method to get the Y coordinate of a point in relation to another element
	 * @param Int $posY position of the parent element
	 * @param Int $sizeY Size of the parent element
	 * @param String $valign Valign of the parent element
	 * @param String $newAlign Valign of the to be positioned element
	 * @return Int
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

	final public static function getAlignedPos($object, $newHalign, $newValign)
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

	final public static function getAlignPosArray($array, $newHalign, $newValign)
	{
		$newPosX = self::getAlignedPosX(
			$array['posX'],
			$array['sizeX'], 
			$array['halign'], 
			$newHalign);
		$newPosY = self::getAlignedPosY(
			$array['posY'], 
			$array['sizeY'], 
			$array['valign'], 
			$newValign);
		return array('x' => $newPosX, 'y' => $newPosY);
	}
}

?>
<?php
/**
 * @package Manialib
 * @author Maxime Raoust
 */

/**
 * Column layout: elements are added below their predecessor
 * @package Manialib
 */
class ColumnLayout extends AbstractLayout
{
	const DIRECTION_DOWN = -1;
	const DIRECTION_UP = 1;
	
	protected $direction = -1;
	
	function setDirection($direction)
	{
		$this->direction = $direction;
	}
	
	function preFilter(GuiElement $item)
	{
		if($this->direction == self::DIRECTION_UP)
		{
			$this->yIndex += $item->getSizeY() + $this->marginHeight;
		}
	}
	
	function postFilter(GuiElement $item)
	{
		if($this->direction == self::DIRECTION_DOWN)
		{
			$this->yIndex -= $item->getSizeY() + $this->marginHeight;
		}
	}
}

?>
<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * Column layout
 * Elements are added below their predecessor
 * @package ManiaLib
 * @subpackage GUIToolkit_Layouts
 */
class ManiaLib_Gui_Layouts_Column extends ManiaLib_Gui_Layouts_AbstractLayout
{
	const DIRECTION_DOWN = -1;
	const DIRECTION_UP = 1;
	
	/**
	 * @ignore
	 */
	protected $direction = -1;
	
	function setDirection($direction)
	{
		$this->direction = $direction;
	}
	
	/**
	 * @ignore
	 */
	function preFilter(ManiaLib_Gui_Element $item)
	{
		if($this->direction == self::DIRECTION_UP)
		{
			$this->yIndex += $item->getSizeY() + $this->marginHeight;
		}
	}
	
	/**
	 * @ignore
	 */
	function postFilter(ManiaLib_Gui_Element $item)
	{
		if($this->direction == self::DIRECTION_DOWN)
		{
			$this->yIndex -= $item->getSizeY() + $this->marginHeight;
		}
	}
}

?>
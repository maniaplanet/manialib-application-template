<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */
 
/**
 * Line layout
 * Elements are added at the right of their predecessor
 * @package ManiaLib
 * @subpackage GUIToolkit_Layouts
 */
class LineLayout extends AbstractLayout
{
	/**
	 * @ignore
	 */
	function postFilter(GuiElement $item)
	{
		$this->xIndex += $item->getSizeX() + $this->marginWidth;
	}
}

?>
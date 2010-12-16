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
class ManiaLib_Gui_Layouts_Line extends ManiaLib_Gui_Layouts_AbstractLayout
{
	/**
	 * @ignore
	 */
	function postFilter(ManiaLib_Gui_Element $item)
	{
		$this->xIndex += $item->getSizeX() + $this->marginWidth;
	}
}

?>
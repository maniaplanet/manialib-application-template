<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 * @subpackage ManialinkGuiToolkit
 */
 
/**
 * Line layout: elements are added at the right of their predecessor
 */
class LineLayout extends AbstractLayout
{
	function postFilter(GuiElement $item)
	{
		$this->xIndex += $item->getSizeX() + $this->marginWidth;
	}
}

?>
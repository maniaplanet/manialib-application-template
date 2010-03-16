<?php
/**
 * Manialink GUI API
 * @author Maxime Raoust
 */
 
/**
 * Line layout: elements are added at the right of their predecessor
 * @package gui_api
 */
class LineLayout extends AbstractLayout
{
	function postFilter(GuiElement $item)
	{
		$this->xIndex += $item->getSizeX() + $this->marginWidth;
	}
}
?>
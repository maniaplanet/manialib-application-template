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
	protected function updateLayout(GuiElement $item)
	{
		$this->xIndex += $item->getSizeX() + $this->marginWidth;
	}
}
?>

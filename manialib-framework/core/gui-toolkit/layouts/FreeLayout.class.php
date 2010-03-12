<?php
/**
 * Manialink GUI API
 * @author Maxime Raoust
 */

/**
 * Free layout : groups elements without positioning them. Usefull to group
 * several elements into another layout
 * 
 * @package gui_api
 */
class FreeLayout extends AbstractLayout
{
	protected function prepareLayout(GuiElement $item)
	{
		$this->xIndex = $item->getPosX();
		$this->yIndex = $item->getPosY();
		$this->zIndex = $item->getPosZ();
	}
}
?>
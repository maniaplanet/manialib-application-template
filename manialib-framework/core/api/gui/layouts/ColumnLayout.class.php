<?php
/**
 * Manialink GUI API
 * @author Maxime Raoust
 */

/**
 * Column layout: elements are added below their predecessor
 * @package gui_api
 */
class ColumnLayout extends AbstractLayout
{
	protected function updateLayout(GuiElement $item)
	{
		$this->yIndex -= $item->getSizeY() + $this->marginHeight;
	}
}
?>

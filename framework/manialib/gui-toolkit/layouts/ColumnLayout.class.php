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
	function postFilter(GuiElement $item)
	{
		$this->yIndex -= $item->getSizeY() + $this->marginHeight;
	}
}

?>
<?php
/**
 * Manialink GUI API
 * @author Philippe Melot
 */

/**
 * Flow layout: column-like, items fill vertically the current column then 
 * the next one on the right etc.
 * @package gui_api
 */
class VerticalFlowLayout extends AbstractLayout
{
	protected $maxWidth = 0;
	protected $currentColumnElementCount = 0;

	protected function prepareLayout(GuiElement $item)
	{
		$availableHeight = $this->sizeY + $this->yIndex - $this->borderHeight;

		// If end of the line is reached
		if($availableHeight < $item->getSizeY() & $this->currentColumnElementCount > 0)
		{
			$this->xIndex += $this->maxWidth + $this->marginWidth;
			$this->yIndex = $this->borderHeight;
			$this->currentColumnElementCount = 0;
			$this->maxWidth = 0;
		}

	}

	protected function updateLayout(GuiElement $item)
	{
		$this->yIndex -= $item->getSizeY() + $this->marginHeight;
		if(!$this->maxWidth || $item->getSizeX() > $this->maxWidth)
		{
			$this->maxWidth = $item->getSizeX();
		}
		$this->currentColumnElementCount++;
	}
}

?>
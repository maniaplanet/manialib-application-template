<?php
/**
 * Manialink GUI API
 * @author Maxime Raoust
 */

/**
 * Flow layout: text-like, items fill the current line then next line etc.
 * @package gui_api
 */
class FlowLayout extends AbstractLayout
{
	protected $maxHeight = 0;
	protected $currentLineElementCount = 0;

	protected function prepareLayout(GuiElement $item)
	{
		$availableWidth = $this->sizeX - $this->xIndex - $this->borderWidth;

		// If end of the line is reached
		if($availableWidth < $item->getSizeX() & $this->currentLineElementCount > 0)
		{
			$this->yIndex -= $this->maxHeight + $this->marginHeight;
			$this->xIndex = $this->borderWidth;
			$this->currentLineElementCount = 0;
			$this->maxHeight = 0;
		}

	}

	protected function updateLayout(GuiElement $item)
	{
		$this->xIndex += $item->getSizeX() + $this->marginWidth;
		if(!$this->maxHeight || $item->getSizeY() > $this->maxHeight)
		{
			$this->maxHeight = $item->getSizeY();
		}
		$this->currentLineElementCount++;
	}
}
?>

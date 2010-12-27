<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Flow layout
 * Column-like, items fill vertically the current column then the next one on the right etc.
 */
class ManiaLib_Gui_Layouts_VerticalFlow extends ManiaLib_Gui_Layouts_AbstractLayout
{
	/**#@+
	 * @ignore
	 */
	protected $maxWidth = 0;
	protected $currentColumnElementCount = 0;
	/**#@-*/

	/**
	 * @ignore
	 */
	function preFilter(ManiaLib_Gui_Element $item)
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

	/**
	 * @ignore
	 */
	function postFilter(ManiaLib_Gui_Element $item)
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
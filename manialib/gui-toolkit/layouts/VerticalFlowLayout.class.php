<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * Flow layout
 * Column-like, items fill vertically the current column then the next one on the right etc.
 * @package ManiaLib
 * @subpackage GUIToolkit_Layouts
 */
class VerticalFlowLayout extends AbstractLayout
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
	function preFilter(GuiElement $item)
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
	function postFilter(GuiElement $item)
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
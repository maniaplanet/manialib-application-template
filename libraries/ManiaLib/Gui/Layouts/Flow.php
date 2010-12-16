<?php
/**
 * @author Maxime Raoust
 * @copyright 2009-2010 NADEO 
 * @package ManiaLib
 */

/**
 * Flow layout
 * Text-like, items fill the current line then next line etc.
 * @package ManiaLib
 * @subpackage GUIToolkit_Layouts
 */
class ManiaLib_Gui_Layouts_Flow extends ManiaLib_Gui_Layouts_AbstractLayout
{
	/**#@+
	 * @ignore
	 */
	protected $maxHeight = 0;
	protected $currentLineElementCount = 0;
	/**#@-*/

	/**
	 * @ignore
	 */
	function preFilter(ManiaLib_Gui_Element $item)
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

	/**
	 * @ignore
	 */
	function postFilter(ManiaLib_Gui_Element $item)
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
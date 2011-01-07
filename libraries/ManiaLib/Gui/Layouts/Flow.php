<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\Gui\Layouts;

/**
 * Flow layout
 * Text-like, items fill the current line then next line etc.
 */
class Flow extends AbstractLayout
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
	function preFilter(\ManiaLib\Gui\Element $item)
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
	function postFilter(\ManiaLib\Gui\Element $item)
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
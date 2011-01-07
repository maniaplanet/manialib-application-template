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
 * Column-like, items fill vertically the current column then the next one on the right etc.
 */
class VerticalFlow extends AbstractLayout
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
	function preFilter(\ManiaLib\Gui\Element $item)
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
	function postFilter(\ManiaLib\Gui\Element $item)
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
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
 * Column layout
 * Elements are added below their predecessor
 */
class Column extends AbstractLayout
{
	const DIRECTION_DOWN = -1;
	const DIRECTION_UP = 1;
	
	/**
	 * @ignore
	 */
	protected $direction = -1;
	
	function setDirection($direction)
	{
		$this->direction = $direction;
	}
	
	/**
	 * @ignore
	 */
	function preFilter(\ManiaLib\Gui\Element $item)
	{
		if($this->direction == self::DIRECTION_UP)
		{
			$this->yIndex += $item->getSizeY() + $this->marginHeight;
		}
	}
	
	/**
	 * @ignore
	 */
	function postFilter(\ManiaLib\Gui\Element $item)
	{
		if($this->direction == self::DIRECTION_DOWN)
		{
			$this->yIndex -= $item->getSizeY() + $this->marginHeight;
		}
	}
}

?>
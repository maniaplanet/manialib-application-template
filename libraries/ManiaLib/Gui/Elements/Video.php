<?php 
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Video
 */
class ManiaLib_Gui_Elements_Video extends ManiaLib_Gui_Elements_Audio
{
	/**
	 * @ignore 
	 */
	protected $xmlTagName = 'video';

	function __construct($sx = 32, $sy = 24)
	{
		$this->sizeX = $sx;
		$this->sizeY = $sy;
	}
}

?>
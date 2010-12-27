<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Icon
 * Should be abstract some day, use classes like "ManiaLib_Gui_Elements_Icons128x128_1" instead
 */
class ManiaLib_Gui_Elements_Icon extends ManiaLib_Gui_Elements_Quad
{
	/**#@+
	 * @ignore
	 */
	protected $style = ManiaLib_Gui_Elements_Quad::Icons128x128_1;
	protected $subStyle = ManiaLib_Gui_Elements_Icons128x128_1::United;
	/**#@-*/

	function __construct($size = 7)
	{
		$this->sizeX = $size;
		$this->sizeY = $size;
	}
}

?>
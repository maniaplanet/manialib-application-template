<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Button
 */
class ManiaLib_Gui_Elements_Button extends ManiaLib_Gui_Elements_Label
{
	const CardButtonMedium       = 'CardButtonMedium';
	const CardButtonMediumWide   = 'CardButtonMediumWide';
	const CardButtonSmallWide     = 'CardButtonSmallWide';
	const CardButtonSmall         = 'CardButtonSmall';
	
	/**#@+
	 * @ignore 
	 */
	protected $subStyle = null;
	protected $style = self::CardButtonMedium;
	/**#@-*/
	
	function __construct($sizeX = 25, $sizeY = 3)
	{
		parent::__construct($sizeX, $sizeY);		
	}
}

?>
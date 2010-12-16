<?php

/**
 * Include
 * Manialink include tag, used to include another Manialink file inside a Manialink
 * Use the setUrl() method
 * ManiaLib_Gui_Manialink::redirectManialink() is a shortcut
 * @package ManiaLib
 * @subpackage GUIToolkit
 */
class ManiaLib_Gui_Elements_IncludeManialink extends ManiaLib_Gui_Element
{
	function __construct()
	{
	}

	protected $xmlTagName = 'include';
	protected $halign = null;
	protected $valign = null;
	protected $posX = null;
	protected $posY = null;
	protected $posZ = null;
}

?>
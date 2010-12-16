<?php

/**
 * Get skin
 * @package ManiaLib
 * @subpackage ManiacodeToolkit 
 */
class ManiaLib_Maniacode_Elements_GetSkin extends ManiaLib_Maniacode_Elements_InstallSkin
{
	/**
	 * @ignore
	 */
	protected $xmlTagName = 'get_skin';
	
	function __construct($name='', $file='', $url='')
	{
		parent::__construct($name, $file, $url);
	}
}

?>
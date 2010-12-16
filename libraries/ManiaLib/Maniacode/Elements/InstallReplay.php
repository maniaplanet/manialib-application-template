<?php

/**
 * Install replay
 * @package ManiaLib
 * @subpackage ManiacodeToolkit 
 */
class ManiaLib_Maniacode_Elements_InstallReplay extends ManiaLib_Maniacode_Elements_FileDownload
{
	/**
	 * @ignore
	 */
	protected $xmlTagName = 'install_replay';
	
	function __construct($name='', $url='')
	{
		parent::__construct($name, $url);
	}
}


?>
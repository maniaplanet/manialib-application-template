<?php

/**
 * Play replay
 * @package ManiaLib
 * @subpackage ManiacodeToolkit 
 */
class ManiaLib_Maniacode_Elements_PlayReplay extends ManiaLib_Maniacode_Elements_FileDownload
{
	/**
	 * @ignore
	 */
	protected $xmlTagName = 'play_replay';
	
	function __construct($name='', $url='')
	{
		parent::__construct($name, $url);
	}
}

?>
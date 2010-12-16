<?php

/**
 * Play track
 * @package ManiaLib
 * @subpackage ManiacodeToolkit 
 */
class ManiaLib_Maniacode_Elements_PlayTrack extends ManiaLib_Maniacode_Elements_FileDownload
{
	/**
	 * @ignore
	 */
	protected $xmlTagName = 'play_track';
	
	function __construct($name='', $url='')
	{
		parent::__construct($name, $url);
	}
}

?>
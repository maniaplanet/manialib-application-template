<?php

/**
 * Package track
 * Use it only with InstallTrackPack
 * @package ManiaLib
 * @subpackage ManiacodeToolkit 
 */
class ManiaLib_Maniacode_Elements_PackageTrack extends ManiaLib_Maniacode_Elements_FileDownload
{
	/**
	 * @ignore
	 */
	protected $xmlTagName = 'track';
	
	function __construct($name='', $url='')
	{
		parent::__construct($name, $url);
	}
}


?>
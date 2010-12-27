<?php
/**
 * @author Philippe Melot
 * @copyright 2009-2010 NADEO 
 */

/**
 * Install track
 */
class ManiaLib_Maniacode_Elements_InstallTrack extends ManiaLib_Maniacode_Elements_FileDownload
{
	/**
	 * @ignore
	 */
	protected $xmlTagName = 'install_track';
	
	function __construct($name='', $url='')
	{
		parent::__construct($name, $url);
	}
}

?>
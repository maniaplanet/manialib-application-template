<?php
/**
 * @author Philippe Melot
 * @copyright 2009-2010 NADEO 
 */

/**
 * Play track
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
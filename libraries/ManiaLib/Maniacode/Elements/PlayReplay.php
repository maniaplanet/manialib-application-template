<?php
/**
 * @author Philippe Melot
 * @copyright 2009-2010 NADEO 
 */

/**
 * Play replay
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
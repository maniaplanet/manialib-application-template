<?php
/**
 * @author Philippe Melot
 * @copyright 2009-2010 NADEO 
 */

/**
 * View replay
 */
class ManiaLib_Maniacode_Elements_ViewReplay extends ManiaLib_Maniacode_Elements_FileDownload
{
	/**
	 * @ignore
	 */
	protected $xmlTagName = 'view_replay';
	
	function __construct($name='', $url='')
	{
		parent::__construct($name, $url);
	}
}


?>
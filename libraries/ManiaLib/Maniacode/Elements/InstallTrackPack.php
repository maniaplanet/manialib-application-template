<?php
/**
 * @author Philippe Melot
 * @copyright 2009-2010 NADEO 
 */

/**
 * Install track pack
 */
class ManiaLib_Maniacode_Elements_InstallTrackPack extends ManiaLib_Maniacode_Component
{
	/**#@+
	 * @ignore
	 */
	protected $xmlTagName = 'install_track_pack';
	protected $tracks = array();
	/**#@-*/
	
	function __construct($name='')
	{
		$this->name = $name;
	}

	function addTrack($name = '',  $url = '')
	{
		$this->tracks[] = new ManiaLib_Maniacode_Elements_PackageTrack($name, $url);
	}
	
	function getLastInsert()
	{
		return end($this->tracks);
	}
	
	protected function postFilter()
	{
		if (isset($this->tracks) && is_array($this->tracks) && count($this->tracks))
		{
			foreach ($this->tracks as $track)
			{
				$track->save();
			}
		}
	}
}

?>
<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\Maniacode\Elements;

/**
 * Install track pack
 */
class InstallTrackPack extends \ManiaLib\Maniacode\Component
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
		$this->tracks[] = new \ManiaLib\Maniacode\Elements\PackageTrack($name, $url);
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
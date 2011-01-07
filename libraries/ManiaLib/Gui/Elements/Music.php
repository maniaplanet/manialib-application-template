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

namespace ManiaLib\Gui\Elements;

/**
 * Music
 */
class Music extends \ManiaLib\Gui\Element
{
	/**#@+
	 * @ignore 
	 */
	protected $xmlTagName = 'music';
	protected $halign = null;
	protected $valign = null;
	protected $posX = null;
	protected $posY = null;
	protected $posZ = null;
	protected $data;
	/**#@-*/
	
	function __construct()
	{
	}
	
	/**
	 * Sets the data to play
	 * @param string The data filename (or URL)
	 * @param bool Whether to prefix the filename with the default media dir URL 
	 */
	function setData($filename, $absoluteUrl = false)
	{
		if($absoluteUrl)
		{
			$this->data = \ManiaLib\Gui\Manialink::$mediaURL.$filename;
		}
		else
		{
			$this->data = $filename;
		}
	}
	
	/**
	 * Returns the data URL
	 * @return string
	 */
	function getData()
	{
		return $this->data;
	}

	/**
	 * @ignore 
	 */
	protected function postFilter()
	{
		if($this->data !== null)
			$this->xml->setAttribute('data', $this->data);
	}
}

?>
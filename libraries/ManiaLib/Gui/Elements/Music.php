<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Music
 */
class ManiaLib_Gui_Elements_Music extends ManiaLib_Gui_Element
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
			$this->data = ManiaLib_Gui_Manialink::$mediaURL.$filename;
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
<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * FileEntry
 * File input field for Manialinks
 */
class ManiaLib_Gui_Elements_FileEntry extends Entry
{
	/**#@+
	 * @ignore 
	 */
	protected $xmlTagName = 'fileentry';
	protected $folder;
	/**#@-*/
	
	/**
	 * Sets the default folder
	 * @param string
	 */
	function setFolder($folder)
	{
		$this->folder = $folder;
	}

	/**
	 * Returns the default folder
	 * @return string
	 */
	function getFolder()
	{
		return $this->folder;
	}

	/**
	 * @ignore 
	 */
	protected function postFilter()
	{
		parent::postFilter();
		if($this->folder !== null)
			$this->xml->setAttribute('folder', $this->folder);
	}
}

?>
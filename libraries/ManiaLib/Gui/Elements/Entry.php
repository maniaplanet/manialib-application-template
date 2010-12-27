<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * Entry
 * Input field for Manialinks
 */
class ManiaLib_Gui_Elements_Entry extends ManiaLib_Gui_Elements_Label
{
	/**#@+
	 * @ignore
	 */
	protected $xmlTagName = 'entry';
	protected $style = '';
	protected $name;
	protected $defaultValue;
	/**#@-*/
	
	/**
	 * Sets the name of the entry. Will be used as the parameter name in the URL
	 * when submitting the page
	 * @param string
	 */
	function setName($name)
	{
		$this->name = $name;
	}
	
	/**
	 * Sets the default value of the entry
	 * @param mixed
	 */
	function setDefault($value)
	{
		$this->defaultValue = $value;
	}
	
	/**
	 * Returns the name of the entry
	 * @return string
	 */
	function getName()
	{
		return $this->name;
	}
	
	/**
	 * Returns the default value of the entry
	 * @return mixed
	 */
	function getDefault()
	{
		return $this->defaultValue;
	}

	/**
	 * @ignore 
	 */
	protected function postFilter()
	{
		parent::postFilter();
		if($this->name !== null)
			$this->xml->setAttribute('name', $this->name);
		if($this->defaultValue !== null)
			$this->xml->setAttribute('default', $this->defaultValue);
	}
}

?>
<?php
/**
 * @author Philippe Melot
 * @copyright 2009-2010 NADEO 
 */

/**
 * Maniacode Toolkit base component
 */
abstract class ManiaLib_Maniacode_Component
{
	/**#@+
	 * @ignore
	 */
	protected $xmlTagName;
	protected $xml;
	protected $name;
	/**#@-*/
	
	/**
	 * This method sets the Name of the file once download
	 *
	 * @param string $name The name of the file once download
	 * @return void
	 *
	 */
	function setName($name)
	{
		$this->name = $name;
	}
	
	/**
	 * This method gets the Name of the element
	 *
	 * @return string This return the name of the file once download
	 *
	 */
	function getName()
	{
		return $this->name;
	}
	
	protected function preFilter() {}
	protected function postFilter() {}
	
	final function save()
	{	
		$this->preFilter();
		
		$this->xml = ManiaLib_Maniacode_Maniacode::$domDocument->createElement($this->xmlTagName);
		end(ManiaLib_Maniacode_Maniacode::$parentNodes)->appendChild($this->xml);
		
		if (isset($this->name))
		{
			$elem  = ManiaLib_Maniacode_Maniacode::$domDocument->createElement('name');
			$value = ManiaLib_Maniacode_Maniacode::$domDocument->createTextNode($this->name);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
		
		$this->postFilter();
	}
}
?>
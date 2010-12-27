<?php 
/**
 * @author Philippe Melot
 * @copyright 2009-2010 NADEO 
 */

/**
 * Goto link
 */
class ManiaLib_Maniacode_Elements_GotoLink extends ManiaLib_Maniacode_Component
{
	/**#@+
	 * @ignore
	 */
	protected $xmlTagName = 'goto';
	protected $link;
	/**#@-*/
	
	function __construct($link = 'manialib')
	{
		$this->setLink($link);
	}
	
	function setLink($link)
	{
		$this->link = $link;
	}
	
	function getLink()
	{
		return $this->link;
	}
	
	protected function postFilter()
	{
		if (isset($this->link))
		{
			$elem  = ManiaLib_Maniacode_Maniacode::$domDocument->createElement('link');
			$value = ManiaLib_Maniacode_Maniacode::$domDocument->createTextNode($this->link);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
	}
}

?>
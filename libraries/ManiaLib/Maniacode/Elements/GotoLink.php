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
 * Goto link
 */
class GotoLink extends \ManiaLib\Maniacode\Component
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
			$elem  = \ManiaLib\Maniacode\Maniacode::$domDocument->createElement('link');
			$value = \ManiaLib\Maniacode\Maniacode::$domDocument->createTextNode($this->link);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
	}
}

?>
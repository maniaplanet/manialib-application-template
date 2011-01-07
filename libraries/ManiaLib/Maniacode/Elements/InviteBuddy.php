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
 * Invite buddy
 */
class InviteBuddy extends \ManiaLib\Maniacode\Component
{
	/**#@+
	 * @ignore
	 */
	protected $xmlTagName = 'invite_buddy';
	protected $email;
	/**#@-*/
	
	function __construct($email = '')
	{
		$this->email = $email;
	}
	
	function setEmail($email)
	{
		$this->email = $email;
	}
	
	function getEmail()
	{
		return $this->email;
	}
	
	protected function postFilter()
	{
		if (isset($this->email))
		{
			$elem  = \ManiaLib\Maniacode\Maniacode::$domDocument->createElement('email');
			$value = \ManiaLib\Maniacode\Maniacode::$domDocument->createTextNode($this->email);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
	}
}

?>
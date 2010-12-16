<?php

/**
 * Invite buddy
 * @package ManiaLib
 * @subpackage ManiacodeToolkit 
 */
class ManiaLib_Maniacode_Elements_InviteBuddy extends ManiaLib_Maniacode_Component
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
			$elem  = ManiaLib_Maniacode_Maniacode::$domDocument->createElement('email');
			$value = ManiaLib_Maniacode_Maniacode::$domDocument->createTextNode($this->email);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
	}
}

?>
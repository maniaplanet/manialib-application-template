<?php 
/**
 * @author Philippe Melot
 * @copyright 2009-2010 NADEO 
 */

/**
 * Add buddy
 */
class ManiaLib_Maniacode_Elements_AddBuddy extends ManiaLib_Maniacode_Component
{
	/**#@+
	 * @ignore
	 */
	protected $xmlTagName = 'add_buddy';
	protected $login;
	/**#@-*/
	
	function __construct($login)
	{
		$this->login = $login;
	}
	
	function setLogin($login)
	{
		$this->login = $login;
	}
	
	function getLogin()
	{
		return $this->login;
	}
	
	protected function postFilter()
	{
		if (isset($this->login))
		{
			$elem  = ManiaLib_Maniacode_Maniacode::$domDocument->createElement('login');
			$value = ManiaLib_Maniacode_Maniacode::$domDocument->createTextNode($this->login);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
	}
}

?>
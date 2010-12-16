<?php

/**
 * Show message
 * @package ManiaLib
 * @subpackage ManiacodeToolkit 
 */
class ManiaLib_Maniacode_Elements_ShowMessage extends ManiaLib_Maniacode_Component
{
	/**#@+
	 * @ignore
	 */
	protected $xmlTagName = 'show_message';
	protected $message;
	/**#@-*/
	
	function __construct($message = 'This is a default message provided by Manialib')
	{
		$this->setMessage($message);
	}
	
	function setMessage($message)
	{
		$this->message = $message;
	}
	
	function getMessage()
	{
		return $this->message;
	}
	
	function postFilter()
	{
		if ($this->message)
		{
			$elem  = ManiaLib_Maniacode_Maniacode::$domDocument->createElement('message');
			$value = ManiaLib_Maniacode_Maniacode::$domDocument->createTextNode($this->message);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
	}
}

?>
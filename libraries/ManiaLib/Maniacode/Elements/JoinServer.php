<?php 

/**
 * Join server
 * @package ManiaLib
 * @subpackage ManiacodeToolkit 
 */
class ManiaLib_Maniacode_Elements_JoinServer extends ManiaLib_Maniacode_Component
{
	/**#@+
	 * Connection type
	 */
	const PLAY = 1;
	const SPEC = 2;
	const REFEREE = 3;
	/**#@-*/
	
	/**#@+
	 * @ignore
	 */
	protected $xmlTagName = 'join_server';
	protected $ip;
	protected $password;
	protected $connectionType;
	/**#@-*/
	
	function __construct($connectionType = self::PLAY)
	{
		$this->connectionType = $connectionType;
	}
	
	function setIp($ip)
	{
		$this->ip = $ip;
	}
	
	function getIp()
	{
		return $this->ip;
	}
	
	function setPassword($password)
	{
		$this->password = $password;
	}
	
	function getPassword()
	{
		return $this->password;
	}
	
	function setConnectionType($connection)
	{
		$this->connectionType = $connection;
	}
	
	function getConnectionType()
	{
		return $this->connectionType;
	}
	
	protected function postFilter()
	{
		if (isset($this->ip))
		{
			$elem  = ManiaLib_Maniacode_Maniacode::$domDocument->createElement('ip');
			$value = ManiaLib_Maniacode_Maniacode::$domDocument->createTextNode($this->ip);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
		
		if (isset($this->password))
		{
			$elem  = ManiaLib_Maniacode_Maniacode::$domDocument->createElement('password');
			$value = ManiaLib_Maniacode_Maniacode::$domDocument->createTextNode($this->password);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
		
		if (isset($this->connectionType))
		{
			$elem  = ManiaLib_Maniacode_Maniacode::$domDocument->createElement('connection_type');
			$value = ManiaLib_Maniacode_Maniacode::$domDocument->createTextNode($this->connectionType);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
	}
}

?>
<?php
/**
 * @author Philippe Melot
 * @copyright 2009-2010 NADEO 
 */

/**
 * Install skin
 */
class ManiaLib_Maniacode_Elements_InstallSkin extends ManiaLib_Maniacode_Elements_FileDownload
{
	/**#@+
	 * @ignore
	 */
	protected $xmlTagName = 'install_skin';
	protected $file;
	/**#@-*/
	
	function __construct($name='', $file='', $url='')
	{
		parent::__construct($name, $url);
		$this->setFile($file);
	}
	
	/**
	 * This method sets the path to install the skin
	 *
	 * @param string $file The path to the skin
	 * @return void 
	 *
	 */
	public function setFile($file)
	{
		$this->file = $file;
	}
	
	/**
	 * This method gets the path to install the skin
	 *
	 * @return string The path to the skin
	 *
	 */
	public function getFile()
	{
		return $this->file;
	}
	
	protected  function postFilter()
	{
		if (isset($this->file))
		{
			$elem  = ManiaLib_Maniacode_Maniacode::$domDocument->createElement('file');
			$value = ManiaLib_Maniacode_Maniacode::$domDocument->createTextNode($this->file);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
	}
}

?>
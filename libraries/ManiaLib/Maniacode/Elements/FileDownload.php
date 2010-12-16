<?php

/**
 * File download
 * @package ManiaLib
 * @subpackage ManiacodeToolkit
 */
abstract class ManiaLib_Maniacode_Elements_FileDownload extends ManiaLib_Maniacode_Component
{
	/**#@+
	 * @ignore
	 */
	protected $url;
	/**#@-*/
	
	function __construct($name = '', $url  = '')
	{
		$this->name = $name;
		$this->url = $url;
	}
	
	/**
	 * This method sets the url to download the file
	 *
	 * @param string $url The url to download the file
	 * @return void
	 *
	 */
	function setUrl($url)
	{
		$this->url = $url;
	}
	
	/**
	 * This method gets the Url of the element
	 *
	 * @return void
	 *
	 */
	function getUrl()
	{
		return $this->url;
	}
	
	protected function postFilter()
	{
		if (isset($this->url))
		{
			$elem  = ManiaLib_Maniacode_Maniacode::$domDocument->createElement('url');
			$value = ManiaLib_Maniacode_Maniacode::$domDocument->createTextNode($this->url);
			$elem->appendChild($value);
			$this->xml->appendChild($elem);
		}
	}
}
	
?>
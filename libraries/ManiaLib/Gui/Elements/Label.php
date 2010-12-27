<?php
/**
 * @author MaximeRaoust
 * @copyright 2009-2010 NADEO 
 */

/**
 * ManiaLib_Gui_Elements_Label
 */
class ManiaLib_Gui_Elements_Label extends ManiaLib_Gui_Elements_Format
{
	/**#@+
	 * @ignore
	 */
	protected $xmlTagName = 'label';
	protected $style = self::TextStaticSmall;
	protected $posX = 0;
	protected $posY = 0;
	protected $posZ = 0;
	protected $text;
	protected $textid;
	protected $autonewline;
	protected $maxline;
	/**#@-*/
	
	function __construct($sizeX = 20, $sizeY = 3)
	{
		$this->sizeX = $sizeX;
		$this->sizeY = $sizeY;
	}
	
	/**
	 * Sets the text
	 * @param string
	 */
	function setText($text)
	{
		$this->text = $text;
	}
	
	/**
	 * Sets the text Id for use with Manialink dictionaries
	 */
	function setTextid($textid)
	{
		$this->textid = $textid;
	}
	
	/**
	 * Sets the maximum number of lines to display
	 * @param int
	 */
	function setMaxline($maxline)
	{
		$this->maxline = $maxline;
	}
	
	/**
	 * Enables wraping the text into several lines if the line is too short
	 */
	function enableAutonewline()
	{
		$this->autonewline = 1;
	}
	
	/**
	 * Returns the text
	 * @return string
	 */
	function getText()
	{
		return $this->text;
	}
	
	/**
	 * Returns the text Id
	 * @return string
	 */
	function getTextid()
	{
		return $this->textid;
	}
	
	/**
	 * Returns the maximum number of lines to display
	 * @return int
	 */
	function getMaxline()
	{
		return $this->maxline;
	}
	
	/**
	 * Returns whether word wrapping is enabled
	 * @return boolean
	 */
	function getAutonewline()
	{
		return $this->autonewline;
	}

	/**
	 * @ignore 
	 */
	protected function postFilter()
	{
		parent::postFilter();
		if($this->text !== null)
		{
			if(ManiaLib_Gui_Manialink::$linksEnabled)
				$this->xml->setAttribute('text', $this->text);
			else
				$this->xml->setAttribute('text', ManiaLib_Utils_TMStrings::stripLinks($this->text));
		}	
		if($this->textid !== null)
		{
			if(ManiaLib_Gui_Manialink::$linksEnabled)
				$this->xml->setAttribute('textid', $this->textid);
			else
				$this->xml->setAttribute('textid', ManiaLib_Utils_TMStrings::stripLinks($this->textid));
		}
		if($this->autonewline !== null)
			$this->xml->setAttribute('autonewline', $this->autonewline);
		if($this->maxline !== null)
			$this->xml->setAttribute('maxline', $this->maxline);
	}
}

?>
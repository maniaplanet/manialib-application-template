<?php
/**
 * Manialink GUI API
 * 
 * @author Maxime Raoust
 */

/**
 * Manialink handler class
 * 
 * @author Maxime Raoust
 * @package gui_api
 */
abstract class Manialink
{
	public static $c;
	public static $domDocument;
	public static $parentNodes;
	
	static public function load()
	{
		self::$domDocument = new DOMDocument;
		$manialink = self::$domDocument->createElement("manialink");
		self::$domDocument->appendChild($manialink);
		self::$parentNodes[] = $manialink;
		
		// TODO Is the <type></type> tag usefull ?
		
		$timeout = self::$domDocument->createElement("timeout");
		$manialink->appendChild($timeout); 
		$timeout->nodeValue = 0;
	}
		
	static public function render()
	{
		header("Content-Type: text/xml; charset=utf-8");
		echo self::$domDocument->saveXML();
	}
	
	static public function beginFrame($x=0, $y=0, $z=0)
	{
		$frame = self::$domDocument->createElement("frame");
		
		if($x||$y||$z)
		{ 
			$frame->setAttribute("posn", "$x $y $z");
		}
		
		end(self::$parentNodes)->appendChild($frame);
		self::$parentNodes[] = $frame;
	}
	
	static public function endFrame()
	{
		if(!end(self::$parentNodes)->hasChildNodes())
		{
			end(self::$parentNodes)->nodeValue = " ";
		}
		array_pop(self::$parentNodes);
	}
}

?>
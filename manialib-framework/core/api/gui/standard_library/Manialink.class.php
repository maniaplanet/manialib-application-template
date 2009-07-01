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
	public static $domDocument;
	public static $parentNodes;
	
	/**
	 * Loads the Manialink objects stack
	 */
	final public static function load()
	{
		self::$domDocument = new DOMDocument;
		self::$parentNodes = array();
		
		$manialink = self::$domDocument->createElement("manialink");
		self::$domDocument->appendChild($manialink);
		self::$parentNodes[] = $manialink;
		
		// TODO Is the <type></type> tag usefull ?
		
		$timeout = self::$domDocument->createElement("timeout");
		$manialink->appendChild($timeout); 
		$timeout->nodeValue = 0;
		
		// ManiaLib watermark. It would be nice to leave it :)
		$ui = new Label;
		$ui->setAlign("center", "bottom");
		$ui->setPosition(15, -48, 1);
		$ui->setTextSize(1);
		$ui->setText('Powered by $<$ccc$o$h[manialib]ManiaLib$h$>');
		$ui->save();
	}
	
	/**
	 * Render the manialink. If $return is set to true, the XML code will be
	 * returned instead of echoed
	 */	
	final public static function render($return = false)
	{
		if($return)
		{
			return self::$domDocument->saveXML();
		}
		else
		{
			header("Content-Type: text/xml; charset=utf-8");
			echo self::$domDocument->saveXML();
		}
	}
	
	/**
	 * Creates a new Manialink frame
	 */
	final public static function beginFrame($x=0, $y=0, $z=0)
	{
		$frame = self::$domDocument->createElement("frame");
		
		if($x||$y||$z)
		{ 
			$frame->setAttribute("posn", "$x $y $z");
		}
		
		end(self::$parentNodes)->appendChild($frame);
		self::$parentNodes[] = $frame;
	}
	
	/**
	 * Closes the current Manialink frame
	 */
	final public static function endFrame()
	{
		if(!end(self::$parentNodes)->hasChildNodes())
		{
			end(self::$parentNodes)->nodeValue = " ";
		}
		array_pop(self::$parentNodes);
	}
}

?>
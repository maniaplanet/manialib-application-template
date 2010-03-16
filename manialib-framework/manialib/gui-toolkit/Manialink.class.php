<?php
/**
 * Manialink GUI API
 * 
 * @author Maxime Raoust
 */

require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'standard.php' );

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
	public static $layoutStack;
	
	/**
	 * Loads the Manialink objects stack
	 */
	final public static function load($createManialinkElement = true, $timeoutValue=0)
	{
		self::$domDocument = new DOMDocument;
		self::$parentNodes = array();
		self::$layoutStack = array();
		
		if($createManialinkElement)
		{
			$manialink = self::$domDocument->createElement('manialink');
			self::$domDocument->appendChild($manialink);
			self::$parentNodes[] = $manialink;
			
			$timeout = self::$domDocument->createElement('timeout');
			$manialink->appendChild($timeout); 
			$timeout->nodeValue = $timeoutValue;
		}
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
			header('Content-Type: text/xml; charset=utf-8');
			echo self::$domDocument->saveXML();
		}
	}
	
	/**
	 * Creates a new Manialink frame
	 */
	final public static function beginFrame($x=0, $y=0, $z=0, $layout=null)
	{
		// Update parent layout
		$parentLayout = end(self::$layoutStack);
		if($parentLayout instanceof AbstractLayout)
		{
			// If we have a current layout, we have a container size to deal with
			if($layout instanceof AbstractLayout)
			{
				$ui = new Spacer($layout->getSizeX(), $layout->getSizeY());
				$ui->setPosition($x, $y, $z);
				
				$parentLayout->preFilter($ui);
				$x += $parentLayout->xIndex;
				$y += $parentLayout->yIndex;
				$z += $parentLayout->zIndex;
				$parentLayout->postFilter($ui);
			}
		}
		
		// Create DOM element
		$frame = self::$domDocument->createElement('frame');
		if($x || $y || $z)
		{ 
			$frame->setAttribute('posn', $x.' '.$y.' '.$z);
		}
		end(self::$parentNodes)->appendChild($frame);
		
		// Update stacks
		self::$parentNodes[] = $frame;
		self::$layoutStack[] = $layout;
	}
	
	/**
	 * Closes the current Manialink frame
	 */
	final public static function endFrame()
	{
		if(!end(self::$parentNodes)->hasChildNodes())
		{
			end(self::$parentNodes)->nodeValue = ' ';
		}
		array_pop(self::$parentNodes);
		array_pop(self::$layoutStack);
	}
}

?>
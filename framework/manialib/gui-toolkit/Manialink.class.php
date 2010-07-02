<?php
/**
 * @package Manialib
 * @author Maxime Raoust
 */

require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'standard.php' );
require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'layouts/AbstractLayout.class.php' );

/**
 * Manialink GUI toolkit main class
 *
 * @package Manialib
 */
abstract class Manialink extends GuiBase
{
	public static $domDocument;
	public static $parentNodes;
	public static $parentLayouts;
	public static $linksEnabled = true;

	/**
	 * Loads the Manialink GUI toolkit. This should be called before doing
	 * anything with the toolkit.
	 *
	 * @param bool Whether you want to create the root "<manialink>" element in
	 * the XML
	 * @param int The timeout value in seconds. Use 0 if you have dynamic pages
	 * to avoid caching
	 */
	final public static function load($createManialinkElement = true, $timeoutValue=0)
	{
		self::$domDocument = new DOMDocument;
		self::$parentNodes = array();
		self::$parentLayouts = array();

		if($createManialinkElement)
		{
			$manialink = self::$domDocument->createElement('manialink');
			self::$domDocument->appendChild($manialink);
			self::$parentNodes[] = $manialink;
				
			$timeout = self::$domDocument->createElement('timeout');
			$manialink->appendChild($timeout);
			$timeout->nodeValue = $timeoutValue;
		}
		else
		{
			$frame = self::$domDocument->createElement('frame');
			self::$domDocument->appendChild($frame);
			self::$parentNodes[] = $frame;
		}
	}

	/**
	 * Renders the Manialink
	 *
	 * @param boolean Wehther you want to return the XML instead of printing it
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
	 * Creates a new Manialink frame, with an optionnal associated layout
	 *
	 * @param float X position
	 * @param float Y position
	 * @param float Z position
	 * @param AbstractLayout The optionnal layout associated with the frame. If
	 * you pass a layout object, all the items inside the frame will be
	 * positionned using constraints defined by the layout
	 */
	final public static function beginFrame($x=0, $y=0, $z=0,
	AbstractLayout $layout=null)
	{
		// Update parent layout
		$parentLayout = end(self::$parentLayouts);
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
		self::$parentLayouts[] = $layout;
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
		array_pop(self::$parentLayouts);
	}

	final public static function redirect($link, $render = true)
	{
		self::$domDocument = new DOMDocument;
		self::$parentNodes = array();
		self::$parentLayouts = array();

		$redirect = self::$domDocument->createElement('redirect');
		$redirect->appendChild(self::$domDocument->createTextNode($link));
		self::$domDocument->appendChild($redirect);
		self::$parentNodes[] = $redirect;

		if($render)
		{
			if(ob_get_contents())
			{
				ob_clean();
			}
			header('Content-Type: text/xml; charset=utf-8');
			echo self::$domDocument->saveXML();
			exit;
		}
		else
		{
			return self::$domDocument->saveXML();
		}
	}

	/**
	 * Add the given XML code to the document
	 */
	static function appendXML($XML)
	{
		$doc = new DOMDocument();
		$doc->loadXML($XML);
		$node = self::$domDocument->importNode($doc->firstChild, true);
		end(self::$parentNodes)->appendChild($node);
	}

	/**
	 * Disable all Manialinks, URLs and actions of GUIElement objects as long as
	 * it is disabled
	 */
	static function disableLinks()
	{
		self::$linksEnabled = false;
	}

	/**
	 * Enable links
	 */
	static function enableLinks()
	{
		self::$linksEnabled = true;
	}
}

?>
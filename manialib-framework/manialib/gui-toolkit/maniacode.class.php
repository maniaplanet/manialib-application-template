<?php
/**
 * @author Philippe Melot
 */

require_once( APP_FRAMEWORK_GUI_TOOLKIT_PATH.'standardManiacode.php' );
/**
 * This is class Maniacode
 */
abstract class Maniacode
{
	public static $domDocument;
	public static $parentNodes;
	
	/**
	 * Loads the Maniacode GUI toolkit. This should be called before doing anything with the toolkit
	 *
	 * @param bool $createManialinkElement Whether you want to create the root "<maniacode>" element in the XML
	 * @return void
	 *
	 */
	final public static function load($createManialinkElement = true)
	{
		self::$domDocument = new DOMDocument;
		self::$parentNodes = array();
		
		if ($createManialinkElement)
		{
			$maniacode = self::$domDocument->createElement('maniacode');
			self::$domDocument->appendChild($maniacode);
			self::$parentNodes[] = $maniacode;
		}
	}
	
	/**
	 * Renders the Maniacode if no return the script will be stopped
	 *
	 * @param bool $return Whether you want to return the XML instead of printing it
	 * @return mixed The XML string if param true, in other case it returns void
	 *
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
			exit();
		}
	}
	
	/**
	 * Add the given XML code to the document
	 *
	 * @param string $XML The given XML
	 * @return void
	 *
	 */
	static function appendXML($XML)
	{
		$doc = new DOMDocument();
		$doc->loadXML($XML);
		$node = self::$domDocument->importNode($doc->firstChild, true);
		end(self::$parentNodes)->appendChild($node);
	}
}
?>
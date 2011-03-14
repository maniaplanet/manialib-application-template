<?php 
/**
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @version     $Revision: 2916 $:
 * @author      $Author: Maxime $:
 * @date        $Date: 2011-03-11 13:15:08 +0100 (ven., 11 mars 2011) $:
 */

namespace ManiaLib\XML;

abstract class Serializer
{
	static protected $document;
	static protected $element;
	
	const T_OBJECT = 'object';
	const T_PROPERTY = 'property';
	const T_ARRAY = 'array';
	const T_LITERAL = 'literal';
	const T_VALUE = 'value';
	
	const A_KEY = 'key';
	const A_NAME = 'name';
	const A_CLASS = 'class';
	
	static function serialize($data, $rootName = 'response')
	{
		self::$document = new \DOMDocument('1.0', 'utf-8');
		$element = self::$document->createElement($rootName);
		self::toDomElement($data, $element);
		self::$document->appendChild($element);
		return self::$document->saveXML();
	}
	
	static function unserialize($xml, $strict = false)
	{
		$document = new \DOMDocument('1.0', 'utf8');
		$document->loadXML($xml);
		return self::fromDomElement($document->documentElement->childNodes->item(0), $strict);
	}
	
	static protected function fromDomElement(\DOMElement $element, $strict = true)
	{
		switch($element->tagName)
		{
			case self::T_VALUE:
				return $element->nodeValue;
				
			case self::T_ARRAY:
				$array = array();
				foreach($element->childNodes as $child)
				{
					if($child instanceof \DOMElement)
					{
						$value = self::fromDomElement($child, $strict);
						if($child->hasAttribute(self::A_KEY))
						{
							$array[$child->getAttribute(self::A_KEY)] = $value;
						}
						else
						{
							$array[] = $value;
						} 
					}
				}
				return $array;
				
			default:
				if($element->hasAttribute(self::A_CLASS))
				{
					if($strict || class_exists('\\'.$element->getAttribute(self::A_CLASS)))
					{
						$className = '\\'.$element->getAttribute(self::A_CLASS);
					}
					else 
					{
						$className = '\\stdClass';
					}
				}
				else 
				{
					$className = '\\stdClass';
				}
					
				$object = new $className;
				foreach($element->childNodes as $child)
				{
					if($child instanceof \DOMElement)
					{
						if($child->tagName == self::T_PROPERTY)
						{
							if($child->hasAttribute(self::A_NAME))
							{
								$propertyName = $child->getAttribute(self::A_NAME);
								$object->$propertyName = self::fromDomElement($child->childNodes->item(0), $strict);
							}
							else
							{
								throw new \Exception('Missing attribute "'.self::A_NAME.
									'" for tag <'.self::T_PROPERTY.'>');
							}
						}
						else
						{
							throw new \Exception('Unexpected tag name "<'.$child->tagName.
								'>" as a child of <'.self::T_OBJECT.'>');
						}
					}
				}
				return $object;
		}
	}
	
	/**
	 * @return \DOMElement
	 */
	static protected function toDomElement($value, \DOMElement $element)
	{
		$document = self::$document;
		if(is_object($value))
		{
			$className = get_class($value);
			$childElement = $document->createElement(self::T_OBJECT);
			$childElement->setAttribute(self::A_CLASS, $className);
			foreach ($value as $objectKey => $objectValue)
			{
				$childChildElement = $document->createElement(self::T_PROPERTY);
				$childChildElement->setAttribute(self::A_NAME, $objectKey);
				$childChildElement->appendChild(self::toDomElement($objectValue, $childChildElement));
				$childElement->appendChild($childChildElement);
			}
			$element->appendChild($childElement);
		}
		elseif(is_array($value))
		{
			$childElement = $document->createElement(self::T_ARRAY);
			foreach ($value as $arrayKey => $arrayValue)
			{
				$childChildElement = self::toDomElement($arrayValue, $childElement);
				$childChildElement->setAttribute(self::A_KEY, $arrayKey);
				$childElement->appendChild($childChildElement);
			}
			$element->appendChild($childElement);
		}
		else
		{
			$childElement = $document->createElement(self::T_VALUE);
			$childElement->appendChild(self::$document->createTextNode($value));
			$element->appendChild($childElement);
		}
		return $childElement;
	}
}

?>
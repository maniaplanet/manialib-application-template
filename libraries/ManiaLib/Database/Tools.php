<?php
/**
 * ManiaLib - Lightweight PHP framework for Manialinks
 * 
 * @copyright   Copyright (c) 2009-2011 NADEO (http://www.nadeo.com)
 * @license     http://www.gnu.org/licenses/lgpl.html LGPL License 3
 * @version     $Revision$:
 * @author      $Author$:
 * @date        $Date$:
 */

namespace ManiaLib\Database;

/**
 * Database tools
 */
abstract class Tools
{
	const ORDER_ASC = 1;
	const ORDER_DESC = -1;
	
	/**
	 * Returns the "LIMIT x,x" string depending on both values
	 */
	static function getLimitString($offset, $length)
	{
		$offset = (int)$offset;
		$length = (int)$length;
		if(!$offset && !$length)
		{
			return '';
		}
		elseif(!$offset && $length==1)
		{
			return 'LIMIT 1';
		}
		else
		{
			return 'LIMIT '.$offset.', '.$length;
		}
	}
	
	/**
	 * @param int 1 or -1
	 * @return " ASC " or " DESC "
	 */
	static function getOrder($order)
	{
		switch($order)
		{
			case null:
			case static::ORDER_ASC: return ' ASC ';
			case static::ORDER_DESC: return ' DESC ';
			default: 
				throw new \InvalidArgumentException(sprintf('Invalid order value: %s', $order));
		}
		
	}
	
	/**
	 * Returns string like "(name1, name2) VALUES (value1, value2)" 
	 */
	static function getValuesString(array $values)
	{
		return 
			'('.implode(', ', array_keys($values)).') '.
			'VALUES '.
			'('.implode(', ', $values).')';
	}
	
	/**
	 * Returns string like "name1=VALUES(name1), name2=VALUES(name2)"
	 */
	static function getOnDuplicateKeyUpdateValuesString(array $valueNames)
	{
		$strings = array(); 
		foreach($valueNames as $valueName)
		{
			$strings[] = $valueName.'=VALUES('.$valueName.')';
		}
		return implode(', ', $strings);
	}
	
	/**
	 * Returns string like "name1=value1, name2=value2"
	 */
	static function getUpdateString(array $values)
	{
		$tmp = array();
		
		foreach ($values as $key => $value)
		{
			$tmp[] = $key.'='.$value;
		}
		return implode(', ', $tmp);
	}
}

?>